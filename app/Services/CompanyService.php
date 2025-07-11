<?php

namespace App\Services;

use App\Models\Company;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class CompanyService
{
    public function __construct(
        private CoordinateExtractionService $coordinateService
    )
    {
    }

    /**
     * Get paginated companies with search and filtering
     */
    public function getPaginatedCompanies(array $filters = []): LengthAwarePaginator
    {
        $query = Company::query()->with(['province', 'city']);

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('national_id', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('ceo_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('interface_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Extract coordinates from Google Maps URL (simple version)
     */
    public function extractCoordinatesFromUrl(string $url): array
    {
        return $this->coordinateService->extractCoordinatesFromUrl($url);
    }

    /**
     * Handle coordinates in company creation/update
     */
    private function handleCoordinates(array &$data): void
    {
        if (isset($data['location_link'])) {
            try {
                $coordinates = $this->extractCoordinatesFromUrl($data['location_link']);

                $data['coordinates'] = $coordinates['coordinates'];
                $data['latitude'] = $coordinates['latitude'];
                $data['longitude'] = $coordinates['longitude'];

            } catch (\Exception $e) {
                // Log error but don't fail the entire operation
                \Log::warning('Coordinate extraction failed for company', [
                    'url' => $data['location_link'],
                    'error' => $e->getMessage()
                ]);

                // Keep original coordinates if extraction fails during update
                if (!isset($data['coordinates'])) {
                    $data['coordinates'] = null;
                    $data['latitude'] = null;
                    $data['longitude'] = null;
                }
            }
        }
    }

    /**
     * Create new company
     */
    public function createCompany(array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Handle file uploads
            $data = $this->handleFileUploads($data, $files);

            // Handle date conversion
            if (isset($data['registration_date'])) {
                $data['registration_date'] = Jalalian::fromFormat('Y/m/d', $data['registration_date'])
                    ->toCarbon()->toDateString();
            }

            // Handle coordinates
            $this->handleCoordinates($data);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            }
            $user = User::query()->create(
                [
                    'name' => $data['name'],
                    'national_id' => $data['national_id'],
                    'phone_number' => $data['interface_phone'],
                    'active' => $data['active'] ?? 0
                ]
            );

            $data['user_id'] = $user->id;
            Company::create($data);

            $user->roles()->sync(Role::query()->whereName(Role::COMPANY_ROLE)->first()->id);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Company creation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update company
     */
    public function updateCompany(Company $company, array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Store old national_id for user lookup
            $oldNationalId = $company->national_id;

            // Handle file uploads
            $data = $this->handleFileUploads($data, $files, $company);

            // Handle date conversion
            if (isset($data['registration_date'])) {
                $data['registration_date'] = Jalalian::fromFormat('Y/m/d', $data['registration_date'])
                    ->toCarbon()->toDateString();
            }

            // Handle coordinates only if location_link changed
            if (isset($data['location_link']) && $data['location_link'] !== $company->location_link) {
                $this->handleCoordinates($data);
            }

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            } else {
                $data['status'] = Config::STATUS_EDITED;
                $data['active'] = 0;
            }

            // Update company
            $company->update($data);

            // Update user
            $user = User::where('national_id', $oldNationalId)->first();
            if ($user) {
                $user->update([
                    'name' => $data['name'],
                    'national_id' => $data['national_id'],
                    'phone_number' => $data['interface_phone'],
                    'active' => $data['active']
                ]);

                // Assign role
                $role = Role::where('name', Role::COMPANY_ROLE)->first();
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Company update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete company
     */
    public function deleteCompany(Company $company): bool
    {
        DB::beginTransaction();

        try {
            // Delete associated user
            $user = User::where('national_id', $company->national_id)->first();
            if ($user) {
                $user->delete();
            }

            // Delete company
            $company->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Company deletion error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(array $data, array $files, Company $company = null): array
    {
        $fileFields = [
            'company_logo' => 'logos',
            'brand_logo' => 'logos',
            'trademark_certificate' => 'certificates',
            'operation_licence' => 'licences',
            'official_newspaper' => 'newspaper'
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
            } elseif ($company && !isset($files[$field])) {
                // Keep existing file if no new file uploaded
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Get company types from config
     */
    public function getCompanyTypes(): array
    {
        $config = Config::where('name', Config::COMPANY_TYPE)->first();

        if (!$config) {
            return [];
        }

        return json_decode($config->value, true) ?? [];
    }

    /**
     * Get statuses
     */
    public function getStatuses(): Collection
    {
        return Config::getStatuses();
    }

    /**
     * Get provinces for dropdown
     */
    public function getProvinces(): Collection
    {
        return Province::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * Get all cities for dropdown
     */
    public function getAllCities(): Collection
    {
        return City::with('province')
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name', 'province_id']);
    }

    /**
     * Get cities by province
     */
    public function getCitiesByProvince($provinceId): Collection
    {
        return City::where('province_id', $provinceId)
            ->where('active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get(['id', 'name']);
    }

    /**
     * Get statistics for dashboard
     */
    public function getStatistics(): array
    {
        $total = Company::count();
        $active = Company::where('active', true)->count();
        $pending = Company::where('status', Config::STATUS_PENDING)->count();
        $confirmed = Company::where('status', Config::STATUS_CONFIRMED)->count();
        $rejected = Company::where('status', Config::STATUS_REJECTED)->count();

        // By province statistics
        $byProvince = Company::with('province')
            ->selectRaw('province_id, COUNT(*) as count')
            ->groupBy('province_id')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'province' => $item->province?->name ?? 'نامشخص',
                    'count' => $item->count
                ];
            });

        // Monthly registration trend (last 6 months)
        $monthlyTrend = Company::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
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
            'by_province' => $byProvince,
            'monthly_trend' => $monthlyTrend
        ];
    }

    /**
     * Prepare data for create form
     */
    public function prepareCreateData(): array
    {
        return [
            'companyTypes' => $this->getCompanyTypes(),
            'statuses' => $this->getStatuses(),
            'provinces' => $this->getProvinces(),
            'cities' => collect([]) // Empty initially
        ];
    }

    /**
     * Prepare data for edit form
     */
    public function prepareEditData(Company $company): array
    {
        $cities = $company->province_id ?
            $this->getCitiesByProvince($company->province_id) :
            collect([]);

        return [
            'company' => $company,
            'companyTypes' => $this->getCompanyTypes(),
            'statuses' => $this->getStatuses(),
            'provinces' => $this->getProvinces(),
            'cities' => $cities,
            'registration_date' => $company->registration_date ?
                Jalalian::fromDateTime($company->registration_date)->toDateString() : null
        ];
    }

    /**
     * Prepare data for show modal
     */
    public function prepareShowData(Company $company): array
    {
        return [
            'company' => $company,
            'companyLogo' => $company->company_logo,
            'brandLogo' => $company->brand_logo,
            'trademarkCertificate' => $company->trademark_certificate,
            'operationLicence' => $company->operation_licence
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Company::query()->with(['province', 'city']);

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('national_id', 'like', '%' . $searchValue . '%')
                    ->orWhere('ceo_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('interface_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('email', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = Company::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $companies = $query->get();
        } else {
            $companies = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($companies as $index => $company) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $company->name,
                $company->type,
                $company->national_id,
                $company->ceo_name,
                $company->ceo_phone,
                $company->interface_name,
                $company->interface_phone,
                $this->formatStatus($company),
                $company->created_at ? Jalalian::fromDateTime($company->created_at)->toDateString() : '-',
                $this->generateActionButtons($company)
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
    private function formatStatus(Company $company): string
    {
        $statusHtml = '';

        // Active/Inactive badge
        if ($company->active) {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">فعال</span> ';
        } else {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">غیرفعال</span> ';
        }

        // Status badge
        $statusHtml .= match ($company->status) {
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
    private function generateActionButtons(Company $company): string
    {
        $buttons = '';

        if (\Gate::allows(Company::COMPANY_INDEX)) {
            $buttons .= '<button class="btn-show inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 ml-1"
                               data-company-id="' . $company->id . '"
                               title="نمایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                           </svg>
                           <span class="mr-1">نمایش</span>
                         </button>';
        }

        if (\Gate::allows(Company::COMPANY_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-1"
                               data-company-id="' . $company->id . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';
        }

        if (\Gate::allows(Company::COMPANY_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                               data-company-id="' . $company->id . '"
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
