<?php

namespace App\Services;

use App\Models\Config;
use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class OrganizationService
{
    /**
     * Get paginated organizations with search and filtering
     */
    public function getPaginatedOrganizations(array $filters = []): LengthAwarePaginator
    {
        $query = OrganizationUser::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('fname', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('lname', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('national_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('organization_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('organization_level', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('phone_number', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Create new organization
     */
    public function createOrganization(array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Handle file uploads
            $data = $this->handleFileUploads($data, $files);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            } else {
                $data['status'] = Config::STATUS_PENDING;
                $data['active'] = 0;
            }

            // Create organization user
            $organization = OrganizationUser::create($data);

            // Create or update user
            $user = User::query()->firstOrCreate(
                [
                    'national_id' => $data['national_id']
                ],
                [
                    'name' => $data['fname'] . ' ' . $data['lname'],
                    'national_id' => $data['national_id'],
                    'phone_number' => $data['phone_number'],
                    'active' => $data['active'] ?? 0
                ],
            );

            // Assign role
            $role = Role::where('name', Role::ORGANIZATION_ROLE)->first();
            if ($role) {
                $user->roles()->sync([$role->id]);
            }

            $user->update(['active' => $data['active'] ?? 0]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Organization creation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update organization
     */
    public function updateOrganization(OrganizationUser $organization, array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Store old national_id for user lookup
            $oldNationalId = $organization->national_id;

            // Handle file uploads
            $data = $this->handleFileUploads($data, $files, $organization);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            } else {
                $data['status'] = Config::STATUS_EDITED;
                $data['active'] = 0;
            }

            // Update organization
            $organization->update($data);

            // Update user
            $user = User::where('national_id', $oldNationalId)->first();
            if ($user) {
                $user->update([
                    'name' => $data['fname'] . ' ' . $data['lname'],
                    'national_id' => $data['national_id'],
                    'phone_number' => $data['phone_number'],
                    'active' => $data['active']
                ]);

                // Assign role
                $role = Role::where('name', Role::ORGANIZATION_ROLE)->first();
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Organization update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete organization
     */
    public function deleteOrganization(OrganizationUser $organization): bool
    {
        DB::beginTransaction();

        try {
            // Delete associated user
            $user = User::where('national_id', $organization->national_id)->first();
            if ($user) {
                $user->delete();
            }

            // Delete organization
            $organization->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Organization deletion error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(array $data, array $files, OrganizationUser $organization = null): array
    {
        $fileFields = [
            'national_card' => 'national',
            'personnel_card' => 'personnel',
            'introduction_letter' => 'introduction'
        ];

        foreach ($fileFields as $field => $folder) {
            if (isset($files[$field])) {
                $file = $files[$field];
                $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
                $path = "storage/{$folder}/" . now()->year . '/' . now()->month . '/' . now()->day;

                try {
                    $file->storeAs($path, $fileName);
                    $data[$field] = $path . '/' . $fileName;
                } catch (\Exception $e) {
                    \Log::error("File upload error for {$field}: " . $e->getMessage());
                    unset($data[$field]);
                }
            } elseif ($organization && !isset($files[$field])) {
                // Keep existing file if no new file uploaded
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Get statuses
     */
    public function getStatuses(): Collection
    {
        return Config::getStatuses();
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): array
    {
        $total = OrganizationUser::count();
        $active = OrganizationUser::where('active', true)->count();
        $pending = OrganizationUser::where('status', Config::STATUS_PENDING)->count();
        $confirmed = OrganizationUser::where('status', Config::STATUS_CONFIRMED)->count();
        $rejected = OrganizationUser::where('status', Config::STATUS_REJECTED)->count();

        // By organization statistics
        $byOrganization = OrganizationUser::selectRaw('organization_name, COUNT(*) as count')
            ->groupBy('organization_name')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'organization' => $item->organization_name,
                    'count' => $item->count
                ];
            });

        // Monthly registration trend (last 6 months)
        $monthlyTrend = OrganizationUser::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => $item->month,
                    'count' => $item->count
                ];
            });

        return [
            'total' => $total,
            'active' => $active,
            'inactive' => $total - $active,
            'pending' => $pending,
            'confirmed' => $confirmed,
            'rejected' => $rejected,
            'by_organization' => $byOrganization,
            'monthly_trend' => $monthlyTrend
        ];
    }

    /**
     * Prepare data for create form
     */
    public function prepareCreateData(): array
    {
        return [
            'statuses' => $this->getStatuses()
        ];
    }

    /**
     * Prepare data for edit form
     */
    public function prepareEditData(OrganizationUser $organization): array
    {
        return [
            'organization' => $organization,
            'statuses' => $this->getStatuses()
        ];
    }

    /**
     * Prepare data for show modal
     */
    public function prepareShowData(OrganizationUser $organization): array
    {
        return [
            'organization' => $organization,
            'nationalCard' => $organization->national_card,
            'personnelCard' => $organization->personnel_card,
            'introductionLetter' => $organization->introduction_letter
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = OrganizationUser::query();

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('fname', 'like', '%' . $searchValue . '%')
                    ->orWhere('lname', 'like', '%' . $searchValue . '%')
                    ->orWhere('national_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('organization_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('organization_level', 'like', '%' . $searchValue . '%')
                    ->orWhere('phone_number', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = OrganizationUser::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $organizations = $query->get();
        } else {
            $organizations = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($organizations as $index => $organization) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $organization->fname . ' ' . $organization->lname,
                $organization->national_id,
                $organization->organization_name,
                $organization->organization_level,
                $organization->phone_number,
                $this->formatStatus($organization),
                $organization->created_at ? Jalalian::fromDateTime($organization->created_at)->toDateString() : '-',
                $this->generateActionButtons($organization)
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
     * Format status display
     */
    private function formatStatus(OrganizationUser $organization): string
    {
        $statusHtml = '';

        // Active/Inactive badge
        if ($organization->active) {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">فعال</span> ';
        } else {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">غیرفعال</span> ';
        }

        // Status badge
        $statusHtml .= match ($organization->status) {
            Config::STATUS_PENDING => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">' . Config::STATUS_PENDING_FA . '</span>',
            Config::STATUS_EDITED => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">' . Config::STATUS_EDITED_FA . '</span>',
            Config::STATUS_CONFIRMED => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">' . Config::STATUS_CONFIRMED_FA . '</span>',
            Config::STATUS_REJECTED => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">' . Config::STATUS_REJECTED_FA . '</span>',
            Config::STATUS_DEACTIVATE => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">' . Config::STATUS_DEACTIVATE_FA . '</span>',
            default => '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">ثبت نشده</span>',
        };

        return $statusHtml;
    }

    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons(OrganizationUser $organization): string
    {
        $buttons = '';

        if (\Gate::allows(OrganizationUser::ORGAN_INDEX)) {
            $buttons .= '<button class="btn-show inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 ml-1"
                               data-organization-id="' . $organization->id . '"
                               title="نمایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                           </svg>
                           <span class="mr-1">نمایش</span>
                         </button>';
        }

        if (\Gate::allows(OrganizationUser::ORGAN_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-1"
                               data-organization-id="' . $organization->id . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';
        }

        if (\Gate::allows(OrganizationUser::ORGAN_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                               data-organization-id="' . $organization->id . '"
                               title="حذف">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                           </svg>
                           <span class="mr-1">حذف</span>
                         </button>';
        }

        return $buttons;
    }
}
