<?php

namespace App\Services;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Morilog\Jalali\Jalalian;

class UserService
{
    /**
     * Get paginated users with search and filtering
     */
    public function getPaginatedUsers(array $filters = []): LengthAwarePaginator
    {
        $query = User::with('roles');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('national_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('active', (bool) $filters['status']);
        }

        // Apply role filter
        if (!empty($filters['role'])) {
            $query->whereHas('roles', function ($q) use ($filters) {
                $q->where('name', $filters['role']);
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Update user with proper validation
     */
    public function updateUser(User $user, array $data): bool
    {
        return $user->update($data);
    }

    /**
     * Get all roles for filtering
     */
    public function getAllRoles(): Collection
    {
        return Role::orderBy('title')->get();
    }

    /**
     * Get user statistics
     */
    public function getUserStats(): array
    {
        return [
            'total' => User::count(),
            'active' => User::where('active', true)->count(),
            'inactive' => User::where('active', false)->count(),
            'admin' => User::whereHas('roles', function ($q) {
                $q->where('name', Role::ADMIN_ROLE);
            })->count(),
            'company' => User::whereHas('roles', function ($q) {
                $q->where('name', Role::COMPANY_ROLE);
            })->count(),
            'greenhouse' => User::whereHas('roles', function ($q) {
                $q->where('name', Role::GREENHOUSE_ROLE);
            })->count(),
        ];
    }

    /**
     * Format user roles for display
     */
    public function formatUserRoles(User $user): string
    {
        return $user->roles->pluck('title')->implode(' | ');
    }

    /**
     * Prepare user for editing
     */
    public function prepareUserForEdit(User $user): array
    {
        return [
            'user' => $user,
            'roles' => $this->getAllRoles(),
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = User::with('roles');

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('national_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            });
        }

        // Handle status filter
        if (isset($request['status']) && $request['status'] !== '') {
            $query->where('active', (bool) $request['status']);
        }

        // Handle role filter
        if (!empty($request['role'])) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request['role']);
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = User::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $users = $query->get();
        } else {
            $users = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($users as $index => $user) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $user->name,
                $user->national_id,
                $user->phone_number,
                $this->formatStatusBadge($user->active),
                $this->formatUserRoles($user),
                Jalalian::fromDateTime($user->created_at)->toDateString(),
                $this->generateActionButtons($user)
            ];
        }

        return [
            'draw' => (int)($request['draw'] ?? 1),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ];
    }

    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons(User $user): string
    {
        $buttons = '';

        if (\Gate::allows(User::USER_EDIT)) {
            // Edit button
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-2"
                               data-user-id="' . $user->id . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';

            // Status toggle button
            if ($user->active) {
                $buttons .= '<button class="btn-toggle-status inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                                   data-user-id="' . $user->id . '"
                                   data-current-status="1"
                                   title="غیرفعال کردن">
                               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                               </svg>
                               <span class="mr-1">غیرفعال</span>
                             </button>';
            } else {
                $buttons .= '<button class="btn-toggle-status inline-flex items-center px-3 py-1.5 text-xs font-medium text-green-600 hover:text-green-800 bg-green-50 hover:bg-green-100 rounded-lg transition-colors duration-200"
                                   data-user-id="' . $user->id . '"
                                   data-current-status="0"
                                   title="فعال کردن">
                               <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                   <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                               </svg>
                               <span class="mr-1">فعال</span>
                             </button>';
            }
        }

        return $buttons;
    }

    /**
     * Format status badge
     */
    private function formatStatusBadge(bool $active): string
    {
        if ($active) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                        <div class="w-1.5 h-1.5 rounded-full bg-green-500 ml-1.5"></div>
                        فعال
                    </span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <div class="w-1.5 h-1.5 rounded-full bg-red-500 ml-1.5"></div>
                    غیرفعال
                </span>';
    }
}
