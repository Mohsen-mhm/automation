<?php

namespace App\Services;

use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\Config;
use App\Models\Role;
use App\Models\User;
use App\Models\Province;
use App\Models\City;
use App\Models\Company;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Morilog\Jalali\Jalalian;

class GreenhouseService
{
    public function __construct(
        private CoordinateExtractionService $coordinateService
    )
    {
    }

    /**
     * Get paginated greenhouses with search and filtering
     */
    public function getPaginatedGreenhouses(array $filters = []): LengthAwarePaginator
    {
        $query = $this->getGreenhouseQuery();

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('licence_number', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('owner_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('owner_national_id', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Get greenhouse query based on user role
     */
    private function getGreenhouseQuery()
    {
        if (auth()->user()->hasRole(Role::ADMIN_ROLE) or auth()->user()->hasRole(Role::ORGANIZATION_ROLE)) {
            return Greenhouse::query();
        }

        // For company users, filter by their automation assignments
        $companyUser = User::query()->find(auth()->id());
        $company = Company::query()->where('national_id', $companyUser->national_id)->first();

        return Greenhouse::query()
            ->whereHas('automation', function ($query) use ($company) {
                $query->where('climate_company_id', $company->id)
                    ->orWhere('feeding_company_id', $company->id);
            });
    }

    /**
     * Create new greenhouse
     */
    public function createGreenhouse(array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Handle file uploads
            $data = $this->handleFileUploads($data, $files);

            // Handle date conversion
            $data = $this->handleDateConversion($data);

            // Handle coordinates
            $this->handleCoordinates($data);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            }

            // Create greenhouse
            $greenhouse = Greenhouse::create($data);

            // Create greenhouse alert
            GreenhouseAlert::create(['greenhouse_id' => $greenhouse->id]);

            // Create or update user
            $user = User::query()->firstOrCreate(
                ['national_id' => $data['owner_national_id']],
                [
                    'name' => $data['name'],
                    'national_id' => $data['owner_national_id'],
                    'phone_number' => $data['owner_phone'],
                    'active' => $data['active'] ?? 0
                ]
            );

            $user->roles()->sync(Role::query()->whereName(Role::GREENHOUSE_ROLE)->first()->id);
            $user->update(['active' => $data['active'] ?? 0]);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Greenhouse creation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update greenhouse
     */
    public function updateGreenhouse(Greenhouse $greenhouse, array $data, array $files): bool
    {
        DB::beginTransaction();

        try {
            // Store old national_id for user lookup
            $oldNationalId = $greenhouse->owner_national_id;

            // Handle file uploads
            $data = $this->handleFileUploads($data, $files, $greenhouse);

            // Handle date conversion
            $data = $this->handleDateConversion($data);

            // Handle coordinates only if location_link changed
            if (isset($data['location_link']) && $data['location_link'] !== $greenhouse->location_link) {
                $this->handleCoordinates($data);
            }

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            } else {
                $data['status'] = Config::STATUS_EDITED;
                $data['active'] = 0;
            }

            // Update greenhouse
            $greenhouse->update($data);

            // Update user
            $user = User::where('national_id', $oldNationalId)->first();
            if ($user) {
                $user->update([
                    'name' => $data['name'],
                    'national_id' => $data['owner_national_id'],
                    'phone_number' => $data['owner_phone'],
                    'active' => $data['active']
                ]);

                // Assign role
                $role = Role::where('name', Role::GREENHOUSE_ROLE)->first();
                if ($role) {
                    $user->roles()->sync([$role->id]);
                }
            }

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Greenhouse update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete greenhouse
     */
    public function deleteGreenhouse(Greenhouse $greenhouse): bool
    {
        DB::beginTransaction();

        try {
            // Delete associated user
            $user = User::where('national_id', $greenhouse->owner_national_id)->first();
            if ($user) {
                $user->delete();
            }

            // Delete greenhouse alert
            $alert = GreenhouseAlert::where('greenhouse_id', $greenhouse->id)->first();
            if ($alert) {
                $alert->delete();
            }

            // Delete greenhouse
            $greenhouse->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Greenhouse deletion error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(array $data, array $files, Greenhouse $greenhouse = null): array
    {
        $fileFields = [
            'operation_licence' => 'licences',
            'image' => 'logos'
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
            } elseif ($greenhouse && !isset($files[$field])) {
                // Keep existing file if no new file uploaded
                unset($data[$field]);
            }
        }

        return $data;
    }

    /**
     * Handle date conversion
     */
    private function handleDateConversion(array $data): array
    {
        $dateFields = ['construction_date', 'operation_date'];

        foreach ($dateFields as $field) {
            if (!empty($data[$field])) {
                try {
                    $data[$field] = Jalalian::fromFormat('Y/m/d', $data[$field])
                        ->toCarbon()->toDateString();
                } catch (\Exception $e) {
                    \Log::warning("Date conversion failed for {$field}: " . $e->getMessage());
                    $data[$field] = null;
                }
            }
        }

        return $data;
    }

    /**
     * Handle coordinates
     */
    private function handleCoordinates(array &$data): void
    {
        if (isset($data['location_link'])) {
            try {
                $coordinates = $this->coordinateService->extractCoordinatesFromUrl($data['location_link']);

                $data['coordinates'] = $coordinates['coordinates'];
                $data['latitude'] = $coordinates['latitude'];
                $data['longitude'] = $coordinates['longitude'];

            } catch (\Exception $e) {
                \Log::warning('Coordinate extraction failed for greenhouse', [
                    'url' => $data['location_link'],
                    'error' => $e->getMessage()
                ]);

                if (!isset($data['coordinates'])) {
                    $data['coordinates'] = null;
                    $data['latitude'] = null;
                    $data['longitude'] = null;
                }
            }
        }
    }

    /**
     * Extract coordinates from Google Maps URL
     */
    public function extractCoordinatesFromUrl(string $url): array
    {
        return $this->coordinateService->extractCoordinatesFromUrl($url);
    }

    /**
     * Get substrates from config
     */
    public function getSubstrates(): array
    {
        $config = Config::where('name', Config::SUBSTRATE)->first();
        if (!$config) {
            return [];
        }
        return json_decode($config->value, true) ?? [];
    }

    /**
     * Get product types from config
     */
    public function getProductTypes(): array
    {
        $config = Config::where('name', Config::PRODUCT_TYPE)->first();
        if (!$config) {
            return [];
        }
        return json_decode($config->value, true) ?? [];
    }

    /**
     * Get greenhouse statuses from config
     */
    public function getGreenhouseStatuses(): array
    {
        $config = Config::where('name', Config::GREENHOUSE_STATUS)->first();
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
        $total = Greenhouse::count();
        $active = Greenhouse::where('active', true)->count();
        $pending = Greenhouse::where('status', Config::STATUS_PENDING)->count();
        $confirmed = Greenhouse::where('status', Config::STATUS_CONFIRMED)->count();
        $rejected = Greenhouse::where('status', Config::STATUS_REJECTED)->count();

        // By province statistics
        $byProvince = Greenhouse::selectRaw('province, COUNT(*) as count')
            ->groupBy('province')
            ->orderByDesc('count')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return [
                    'province' => $item->province ?? 'نامشخص',
                    'count' => $item->count
                ];
            });

        // Monthly registration trend (last 6 months)
        $monthlyTrend = Greenhouse::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
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
            'substrates' => $this->getSubstrates(),
            'productTypes' => $this->getProductTypes(),
            'greenhouseStatuses' => $this->getGreenhouseStatuses(),
            'statuses' => $this->getStatuses(),
            'provinces' => $this->getProvinces(),
        ];
    }

    /**
     * Prepare data for edit form
     */
    public function prepareEditData(Greenhouse $greenhouse): array
    {
        return [
            'greenhouse' => $greenhouse,
            'substrates' => $this->getSubstrates(),
            'productTypes' => $this->getProductTypes(),
            'greenhouseStatuses' => $this->getGreenhouseStatuses(),
            'statuses' => $this->getStatuses(),
            'provinces' => $this->getProvinces(),
            'construction_date' => $greenhouse->construction_date ?
                Jalalian::fromDateTime($greenhouse->construction_date)->toDateString() : null,
            'operation_date' => $greenhouse->operation_date ?
                Jalalian::fromDateTime($greenhouse->operation_date)->toDateString() : null
        ];
    }

    /**
     * Prepare data for show modal
     */
    public function prepareShowData(Greenhouse $greenhouse): array
    {
        return [
            'greenhouse' => $greenhouse,
            'image' => $greenhouse->image,
            'operationLicence' => $greenhouse->operation_licence
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = $this->getGreenhouseQuery();

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhere('licence_number', 'like', '%' . $searchValue . '%')
                    ->orWhere('owner_name', 'like', '%' . $searchValue . '%')
                    ->orWhere('owner_national_id', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = $this->getGreenhouseQuery()->count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $greenhouses = $query->get();
        } else {
            $greenhouses = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($greenhouses as $index => $greenhouse) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $greenhouse->name,
                $greenhouse->licence_number,
                $greenhouse->meterage,
                $greenhouse->owner_name,
                $greenhouse->owner_phone,
                $greenhouse->owner_national_id,
                $this->formatStatus($greenhouse),
                $greenhouse->created_at ? Jalalian::fromDateTime($greenhouse->created_at)->toDateString() : '-',
                $this->generateActionButtons($greenhouse)
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
    private function formatStatus(Greenhouse $greenhouse): string
    {
        $statusHtml = '';

        // Active/Inactive badge
        if ($greenhouse->active) {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">فعال</span> ';
        } else {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">غیرفعال</span> ';
        }

        // Status badge
        $statusHtml .= match ($greenhouse->status) {
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
    private function generateActionButtons(Greenhouse $greenhouse): string
    {
        $buttons = '';

        if (\Gate::allows(Greenhouse::GREENHOUSE_INDEX)) {
            $buttons .= '<button class="btn-show inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 ml-1"
                              data-greenhouse-id="' . $greenhouse->id . '"
                              title="نمایش">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                          <span class="mr-1">نمایش</span>
                        </button>';
        }

        if (\Gate::allows(Greenhouse::GREENHOUSE_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-1"
                              data-greenhouse-id="' . $greenhouse->id . '"
                              title="ویرایش">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                          </svg>
                          <span class="mr-1">ویرایش</span>
                        </button>';
            $buttons .= '<a class="btn-alerts inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 ml-1"
                              href="' . route('panel.alerts.admin', $greenhouse->id) . '"
                              title="محدوده ها">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                          </svg>
                          <span class="mr-1">محدوده ها</span>
                        </a>';
        }

        if (\Gate::allows(Greenhouse::GREENHOUSE_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                              data-greenhouse-id="' . $greenhouse->id . '"
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
