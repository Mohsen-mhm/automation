<?php

namespace App\Services;

use App\Models\Automation;
use App\Models\Company;
use App\Models\Config;
use App\Models\Greenhouse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Morilog\Jalali\Jalalian;

class AutomationService
{
    /**
     * Get paginated automations with search and filtering
     */
    public function getPaginatedAutomations(array $filters = []): LengthAwarePaginator
    {
        $query = Automation::query()->with(['greenhouse', 'climateCompany', 'feedingCompany']);

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->whereHas('greenhouse', function ($greenhouse) use ($filters) {
                    $greenhouse->where('name', 'like', '%' . $filters['search'] . '%')
                        ->orWhere('licence_number', 'like', '%' . $filters['search'] . '%');
                })
                    ->orWhereHas('climateCompany', function ($company) use ($filters) {
                        $company->where('name', 'like', '%' . $filters['search'] . '%')
                            ->orWhere('national_id', 'like', '%' . $filters['search'] . '%');
                    })
                    ->orWhereHas('feedingCompany', function ($company) use ($filters) {
                        $company->where('name', 'like', '%' . $filters['search'] . '%')
                            ->orWhere('national_id', 'like', '%' . $filters['search'] . '%');
                    })
                    ->orWhere('climate_api_link', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('feeding_api_link', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Create new automation
     */
    public function createAutomation(array $data): bool
    {
        DB::beginTransaction();

        try {
            // Handle date conversion
            $data = $this->handleDateConversion($data);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            }

            Automation::create($data);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Automation creation error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update automation
     */
    public function updateAutomation(Automation $automation, array $data): bool
    {
        DB::beginTransaction();

        try {
            // Handle date conversion
            $data = $this->handleDateConversion($data);

            // Set active status based on status
            if (isset($data['status'])) {
                $data['active'] = $data['status'] == Config::STATUS_CONFIRMED ? 1 : 0;
            } else {
                $data['status'] = Config::STATUS_EDITED;
                $data['active'] = 0;
            }

            $automation->update($data);

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Automation update error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Delete automation
     */
    public function deleteAutomation(Automation $automation): bool
    {
        DB::beginTransaction();

        try {
            $automation->delete();

            DB::commit();
            return true;

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Automation deletion error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Handle date conversion from Jalali to Gregorian
     */
    private function handleDateConversion(array $data): array
    {
        $dateFields = ['climate_date', 'feeding_date', 'climate_linked_date', 'feeding_linked_date'];

        foreach ($dateFields as $field) {
            if (isset($data[$field]) && !empty($data[$field])) {
                try {
                    $data[$field] = Jalalian::fromFormat('Y/m/d', $data[$field])
                        ->toCarbon()->toDateString();
                } catch (\Exception $e) {
                    // If conversion fails, set to null
                    $data[$field] = null;
                }
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
        $total = Automation::count();
        $active = Automation::where('active', true)->count();
        $pending = Automation::where('status', Config::STATUS_PENDING)->count();
        $confirmed = Automation::where('status', Config::STATUS_CONFIRMED)->count();
        $rejected = Automation::where('status', Config::STATUS_REJECTED)->count();

        // Monthly registration trend (last 6 months)
        $monthlyTrend = Automation::selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
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
            'monthly_trend' => $monthlyTrend
        ];
    }

    /**
     * Prepare data for create form
     */
    public function prepareCreateData(): array
    {
        return [
            'statuses' => $this->getStatuses(),
            'greenhouses' => Greenhouse::all(),
            'climate_companies' => Company::where('climate_system', true)->get(),
            'feeding_companies' => Company::where('feeding_system', true)->get(),
        ];
    }

    /**
     * Prepare data for edit form
     */
    public function prepareEditData(Automation $automation): array
    {
        return [
            'automation' => $automation,
            'statuses' => $this->getStatuses(),
            'greenhouses' => Greenhouse::all(),
            'climate_companies' => Company::where('climate_system', true)->get(),
            'feeding_companies' => Company::where('feeding_system', true)->get(),
            'climate_date' => $automation->climate_date ?
                Jalalian::fromDateTime($automation->climate_date)->toDateString() : null,
            'feeding_date' => $automation->feeding_date ?
                Jalalian::fromDateTime($automation->feeding_date)->toDateString() : null,
            'climate_linked_date' => $automation->climate_linked_date ?
                Jalalian::fromDateTime($automation->climate_linked_date)->toDateString() : null,
            'feeding_linked_date' => $automation->feeding_linked_date ?
                Jalalian::fromDateTime($automation->feeding_linked_date)->toDateString() : null,
        ];
    }

    /**
     * Prepare data for show modal
     */
    public function prepareShowData(Automation $automation): array
    {
        return [
            'automation' => $automation,
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Automation::query()->with(['greenhouse', 'climateCompany', 'feedingCompany']);

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->whereHas('greenhouse', function ($greenhouse) use ($searchValue) {
                    $greenhouse->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('licence_number', 'like', '%' . $searchValue . '%');
                })
                    ->orWhereHas('climateCompany', function ($company) use ($searchValue) {
                        $company->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('national_id', 'like', '%' . $searchValue . '%');
                    })
                    ->orWhereHas('feedingCompany', function ($company) use ($searchValue) {
                        $company->where('name', 'like', '%' . $searchValue . '%')
                            ->orWhere('national_id', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = Automation::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $automations = $query->get();
        } else {
            $automations = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($automations as $index => $automation) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $automation->greenhouse ?
                    '<a class="font-medium text-blue-600 hover:underline" href="' . route('panel.greenhouses.index', 'table-search=' . $automation->greenhouse->licence_number) . '">' . $automation->greenhouse->name . ' - ' . $automation->greenhouse->licence_number . '</a>' : '-',
                $automation->climateCompany ?
                    '<a class="font-medium text-blue-600 hover:underline" href="' . route('panel.companies.index', 'table-search=' . $automation->climateCompany->national_id) . '">' . $automation->climateCompany->name . ' - ' . $automation->climateCompany->national_id . '</a>' : '-',
                $automation->climate_date ? Jalalian::fromDateTime($automation->climate_date)->toDateString() : '-',
                $automation->feedingCompany ?
                    '<a class="font-medium text-blue-600 hover:underline" href="' . route('panel.companies.index', 'table-search=' . $automation->feedingCompany->national_id) . '">' . $automation->feedingCompany->name . ' - ' . $automation->feedingCompany->national_id . '</a>' : '-',
                $automation->feeding_date ? Jalalian::fromDateTime($automation->feeding_date)->toDateString() : '-',
                $this->formatStatus($automation),
                $automation->created_at ? Jalalian::fromDateTime($automation->created_at)->toDateString() : '-',
                $this->generateActionButtons($automation)
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
    private function formatStatus(Automation $automation): string
    {
        $statusHtml = '';

        // Active/Inactive badge
        if ($automation->active) {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">فعال</span> ';
        } else {
            $statusHtml .= '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">غیرفعال</span> ';
        }

        // Status badge
        $statusHtml .= match ($automation->status) {
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
    private function generateActionButtons(Automation $automation): string
    {
        $buttons = '';

        if (\Gate::allows(Automation::AUTOMATION_INDEX)) {
            $buttons .= '<button class="btn-show inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-600 hover:text-indigo-800 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition-colors duration-200 ml-1"
                               data-automation-id="' . $automation->id . '"
                               title="نمایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                          </svg>
                          <span class="mr-1">نمایش</span>
                        </button>';
        }

        if (\Gate::allows(Automation::AUTOMATION_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-1"
                              data-automation-id="' . $automation->id . '"
                              title="ویرایش">
                          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                          </svg>
                          <span class="mr-1">ویرایش</span>
                        </button>';
        }

        if (\Gate::allows(Automation::AUTOMATION_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                              data-automation-id="' . $automation->id . '"
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
