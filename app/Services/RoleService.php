<?php

namespace App\Services;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class RoleService
{
    /**
     * Get paginated roles with search and filtering
     */
    public function getPaginatedRoles(array $filters = []): LengthAwarePaginator
    {
        $query = Role::query()->with('permissions');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Update role permissions
     */
    public function updateRolePermissions(Role $role, array $data): bool
    {
        try {
            DB::beginTransaction();

            $permissions = $data['permissions'] ?? [];

            // Validate permissions exist
            $validPermissions = Permission::whereIn('id', $permissions)->pluck('id')->toArray();

            // Sync permissions
            $role->permissions()->sync($validPermissions);

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating role permissions: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all permissions with pagination
     */
    public function getPaginatedPermissions(int $page = 1, int $perPage = 10): LengthAwarePaginator
    {
        return Permission::orderBy('id', 'desc')->paginate($perPage, ['*'], 'page', $page);
    }

    /**
     * Get all permissions
     */
    public function getAllPermissions(): Collection
    {
        return Permission::orderBy('title', 'asc')->get();
    }

    /**
     * Prepare role for editing
     */
    public function prepareRoleForEdit(Role $role): array
    {
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        $allPermissions = $this->getAllPermissions();

        return [
            'role' => $role,
            'rolePermissions' => $rolePermissions,
            'permissions' => $allPermissions
        ];
    }

    /**
     * Get role statistics
     */
    public function getRoleStats(): array
    {
        $totalRoles = Role::count();
        $rolesWithPermissions = Role::has('permissions')->count();
        $rolesWithoutPermissions = $totalRoles - $rolesWithPermissions;
        $totalPermissions = Permission::count();
        $avgPermissionsPerRole = $totalRoles > 0 ? round(DB::table('role_has_permissions')->count() / $totalRoles, 2) : 0;

        return [
            'total_roles' => $totalRoles,
            'roles_with_permissions' => $rolesWithPermissions,
            'roles_without_permissions' => $rolesWithoutPermissions,
            'total_permissions' => $totalPermissions,
            'avg_permissions_per_role' => $avgPermissionsPerRole
        ];
    }

    /**
     * Bulk update permissions for multiple roles
     */
    public function bulkUpdatePermissions(array $roleIds, array $permissionIds, string $action): array
    {
        try {
            DB::beginTransaction();

            $roles = Role::whereIn('id', $roleIds)->get();
            $validPermissions = Permission::whereIn('id', $permissionIds)->pluck('id')->toArray();

            $results = [];

            foreach ($roles as $role) {
                if ($action === 'assign') {
                    // Add permissions without removing existing ones
                    $currentPermissions = $role->permissions->pluck('id')->toArray();
                    $newPermissions = array_unique(array_merge($currentPermissions, $validPermissions));
                    $role->permissions()->sync($newPermissions);
                } else {
                    // Remove specified permissions
                    $role->permissions()->detach($validPermissions);
                }

                $results[] = [
                    'role_id' => $role->id,
                    'role_title' => $role->title,
                    'permissions_count' => $role->permissions()->count()
                ];
            }

            DB::commit();
            return $results;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Clone role with all permissions
     */
    public function cloneRole(Role $originalRole, string $newTitle): Role
    {
        try {
            DB::beginTransaction();

            // Create new role
            $newRole = Role::create([
                'title' => $newTitle,
                'name' => \Str::slug($newTitle),
                'guard_name' => $originalRole->guard_name
            ]);

            // Copy permissions
            $permissionIds = $originalRole->permissions->pluck('id')->toArray();
            $newRole->permissions()->sync($permissionIds);

            DB::commit();
            return $newRole;
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Role::query()->with('permissions');

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = Role::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = $request['start'] ?? 0;
        $length = $request['length'] ?? 10;
        $roles = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($roles as $index => $role) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $this->formatRoleTitle($role),
                $this->generateActionButtons($role)
            ];
        }

        return [
            'draw' => intval($request['draw'] ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
    }

    /**
     * Format role title with permission count
     */
    private function formatRoleTitle(Role $role): string
    {
        $permissionsCount = $role->permissions->count();
        $badge = $permissionsCount > 0
            ? '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 mr-2">' . $permissionsCount . ' دسترسی</span>'
            : '<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 mr-2">بدون دسترسی</span>';

        return '<div class="flex items-center"><div class="font-medium text-gray-900">' . $role->title . '</div>' . $badge . '</div>';
    }

    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons(Role $role): string
    {
        $buttons = '';

        if (\Gate::allows(Permission::PERMISSION_ASSIGN)) {
            $buttons .= '<button class="btn-assign inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 mr-2"
                               data-role-id="' . $role->id . '"
                               title="تخصیص دسترسی">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                           </svg>
                           <span class="mr-1">تخصیص دسترسی</span>
                         </button>';
        }

        if (\Gate::allows(Role::ROLE_INDEX ?? 'roles.view')) {
            $buttons .= '<button class="btn-view inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200 mr-2"
                               data-role-id="' . $role->id . '"
                               title="مشاهده جزئیات">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                           </svg>
                           <span class="mr-1">جزئیات</span>
                         </button>';
        }

        return $buttons ?: '<span class="text-gray-400 text-sm">بدون عملیات</span>';
    }

    /**
     * Format date helper
     */
    private function formatDate($date): string
    {
        if (!$date) return '-';

        try {
            return verta($date)->format('Y/m/d');
        } catch (\Exception $e) {
            return $date->format('Y-m-d');
        }
    }
}
