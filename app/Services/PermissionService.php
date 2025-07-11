<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class PermissionService
{
    /**
     * Get paginated permissions with search and filtering
     */
    public function getPaginatedPermissions(array $filters = []): LengthAwarePaginator
    {
        $query = Permission::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('name', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Apply category filter
        if (!empty($filters['category'])) {
            $query->where('name', 'like', $filters['category'] . '.%');
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Get all permissions
     */
    public function getAllPermissions(): Collection
    {
        return Permission::orderBy('id', 'desc')->get();
    }

    /**
     * Get permission category from name
     */
    private function getPermissionCategory(string $name): array
    {
        if (str_contains($name, 'admin') || str_contains($name, 'system')) {
            return ['text' => 'مدیریتی', 'class' => 'category-admin'];
        } elseif (str_contains($name, 'user') || str_contains($name, 'profile')) {
            return ['text' => 'کاربری', 'class' => 'category-user'];
        } else {
            return ['text' => 'سیستمی', 'class' => 'category-system'];
        }
    }

    /**
     * Format creation date
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

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Permission::query();

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('name', 'like', '%' . $searchValue . '%');
            });
        }

        // Handle category filter
        if (!empty($request['category'])) {
            $query->where('name', 'like', $request['category'] . '.%');
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = Permission::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = $request['start'] ?? 0;
        $length = $request['length'] ?? 10;
        $permissions = $query->skip($start)->take($length)->get();

        $data = [];
        foreach ($permissions as $index => $permission) {
            $rowIndex = $start + $index + 1;
            $category = $this->getPermissionCategory($permission->name);

            $data[] = [
                $rowIndex,
                $permission->title,
                $permission->name,
                $this->generateCategoryBadge($category),
                $this->formatDate($permission->created_at),
                $permission->id // Hidden ID for details modal
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
     * Generate category badge HTML
     */
    private function generateCategoryBadge(array $category): string
    {
        return '<span class="category-badge ' . $category['class'] . '">' . $category['text'] . '</span>';
    }

    /**
     * Get permission statistics
     */
    public function getPermissionStats(): array
    {
        $total = Permission::count();
        $systemCount = Permission::where('name', 'like', 'system.%')->count();
        $adminCount = Permission::where('name', 'like', 'admin.%')->count();
        $userCount = $total - $systemCount - $adminCount;

        return [
            'total' => $total,
            'system' => $systemCount,
            'admin' => $adminCount,
            'user' => $userCount
        ];
    }

    /**
     * Get permission details
     */
    public function getPermissionDetails(int $permissionId): ?array
    {
        $permission = Permission::with('roles')->find($permissionId);

        if (!$permission) {
            return null;
        }

        $category = $this->getPermissionCategory($permission->name);
        $rolesCount = $permission->roles()->count();

        return [
            'id' => $permission->id,
            'title' => $permission->title,
            'name' => $permission->name,
            'description' => $permission->description ?? 'توضیحی ثبت نشده است.',
            'category' => $category['text'],
            'guard_name' => $permission->guard_name ?? 'web',
            'created_at' => $this->formatDate($permission->created_at),
            'updated_at' => $this->formatDate($permission->updated_at),
            'roles_count' => $rolesCount
        ];
    }
}
