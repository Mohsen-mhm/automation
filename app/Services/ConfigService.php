<?php

namespace App\Services;

use App\Models\Config;
use App\Models\Filter;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ConfigService
{
    /**
     * Get paginated configs with search and filtering
     */
    public function getPaginatedConfigs(array $filters = []): LengthAwarePaginator
    {
        $query = Config::query();

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('value', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Default sorting
        $query->orderBy('id', 'desc');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Update config with proper value formatting
     */
    public function updateConfig(Config $config, array $data): bool
    {
        // Handle JSON type values
        if ($config->type == Config::JSON_TYPE && isset($data['value']) && is_array($data['value'])) {
            $data['value'] = json_encode(array_values($data['value']));
        }

        return $config->update($data);
    }

    /**
     * Get config value
     */
    public function getConfigValue(string $key, $default = null)
    {
        $config = Config::where('key', $key)->first();

        if (!$config) {
            return $default;
        }

        if ($config->type == Config::JSON_TYPE) {
            return json_decode($config->value, true);
        }

        return $config->value;
    }

    /**
     * Update multiple filters status
     */
    public function updateFiltersStatus(array $activeFilterUuids): bool
    {
        try {
            // Get all filters
            $allFilters = Filter::all();

            foreach ($allFilters as $filter) {
                if (in_array($filter->uuid, $activeFilterUuids)) {
                    $filter->activate();
                } else {
                    $filter->deactivate();
                }
            }

            return true;
        } catch (\Exception $e) {
            \Log::error('Error updating filters status: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get active filters
     */
    public function getActiveFilters(): Collection
    {
        return Filter::where('active', true)->get();
    }

    /**
     * Get all filters
     */
    public function getAllFilters(): Collection
    {
        return Filter::orderBy('id')->get();
    }

    /**
     * Format config value for display
     */
    public function formatConfigValue(Config $config): string
    {
        if ($config->type == Config::JSON_TYPE) {
            $jsonValues = json_decode($config->value, true);
            return is_array($jsonValues) ? implode(' || ', $jsonValues) : '';
        }

        return $config->value . ' تومان';
    }

    /**
     * Prepare config value for editing based on type
     */
    public function prepareConfigForEdit(Config $config): array
    {
        $isJsonType = $config->type == Config::JSON_TYPE;

        if ($isJsonType) {
            $jsonValues = json_decode($config->value, true) ?? [];
            $formattedValues = collect($jsonValues)->map(function ($item, $index) {
                return [
                    'id' => 'item_' . $index,
                    'value' => $item
                ];
            })->toArray();

            return [
                'config' => $config,
                'is_json_type' => true,
                'json_values' => $formattedValues,
                'view_type' => 'json'
            ];
        }

        return [
            'config' => $config,
            'is_json_type' => false,
            'string_value' => $config->value,
            'view_type' => 'string'
        ];
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Config::query();

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('title', 'like', '%' . $searchValue . '%')
                    ->orWhere('value', 'like', '%' . $searchValue . '%');
            });
        }

        // Default sorting by ID desc
        $query->orderBy('id', 'desc');

        $totalRecords = Config::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $configs = $query->get();
        } else {
            $configs = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($configs as $index => $config) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $config->title,
                $this->formatConfigValue($config),
                $this->generateActionButtons($config)
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
    private function generateActionButtons(Config $config): string
    {
        $buttons = '';

        if (\Gate::allows(Config::CONFIG_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200"
                               data-config-id="' . $config->id . '"
                               data-config-type="' . $config->type . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';
        }

        return $buttons;
    }
}
