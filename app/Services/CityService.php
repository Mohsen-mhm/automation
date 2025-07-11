<?php

namespace App\Services;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CityService
{
    /**
     * Get paginated cities with search and filtering
     */
    public function getPaginatedCities(array $filters = []): LengthAwarePaginator
    {
        $query = City::with('province');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['search'] . '%')
                    ->orWhereHas('province', function ($q2) use ($filters) {
                        $q2->where('name', 'like', '%' . $filters['search'] . '%');
                    });
            });
        }

        // Apply province filter
        if (!empty($filters['province_id'])) {
            $query->where('province_id', $filters['province_id']);
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('active', (bool) $filters['status']);
        }

        // Default sorting
        $query->orderBy('sort_order')->orderBy('name');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Create new city
     */
    public function createCity(array $data): City
    {
        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = City::where('province_id', $data['province_id'])->max('sort_order') + 1;
        }

        return City::create($data);
    }

    /**
     * Update city
     */
    public function updateCity(City $city, array $data): bool
    {
        return $city->update($data);
    }

    /**
     * Delete city
     */
    public function deleteCity(City $city): bool
    {
        return $city->delete();
    }

    /**
     * Toggle city status
     */
    public function toggleStatus(City $city): bool
    {
        return $city->update(['active' => !$city->active]);
    }

    /**
     * Get cities by province
     */
    public function getCitiesByProvince(int $provinceId): Collection
    {
        return City::byProvince($provinceId)->active()->ordered()->get();
    }

    /**
     * Get all active cities
     */
    public function getActiveCities(): Collection
    {
        return City::with('province')->active()->ordered()->get();
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = City::with('province');

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where(function ($q) use ($searchValue) {
                $q->where('name', 'like', '%' . $searchValue . '%')
                    ->orWhereHas('province', function ($q2) use ($searchValue) {
                        $q2->where('name', 'like', '%' . $searchValue . '%');
                    });
            });
        }

        // Handle province filter
        if (!empty($request['province_id'])) {
            $query->where('province_id', $request['province_id']);
        }

        // Handle status filter
        if (isset($request['status']) && $request['status'] !== '') {
            $query->where('active', (bool) $request['status']);
        }

        // Default sorting
        $query->orderBy('sort_order')->orderBy('name');

        $totalRecords = City::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $cities = $query->get();
        } else {
            $cities = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($cities as $index => $city) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $city->name,
                $city->province->name,
                $this->generateStatusBadge($city->active),
                $city->sort_order,
                $city->created_at->format('Y/m/d H:i'),
                $this->generateActionButtons($city)
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
     * Generate status badge
     */
    private function generateStatusBadge(bool $active): string
    {
        if ($active) {
            return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                        <div class="w-1.5 h-1.5 rounded-full bg-emerald-500 ml-1.5"></div>
                        فعال
                    </span>';
        }

        return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                    <div class="w-1.5 h-1.5 rounded-full bg-red-500 ml-1.5"></div>
                    غیرفعال
                </span>';
    }

    /**
     * Generate action buttons for DataTables
     */
    private function generateActionButtons(City $city): string
    {
        $buttons = '';

        if (\Gate::allows(City::CITY_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-2"
                               data-city-id="' . $city->id . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';

            $statusText = $city->active ? 'غیرفعال' : 'فعال';
            $statusColor = $city->active ? 'orange' : 'emerald';
            $buttons .= '<button class="btn-toggle inline-flex items-center px-3 py-1.5 text-xs font-medium text-' . $statusColor . '-600 hover:text-' . $statusColor . '-800 bg-' . $statusColor . '-50 hover:bg-' . $statusColor . '-100 rounded-lg transition-colors duration-200 ml-2"
                               data-city-id="' . $city->id . '"
                               title="تغییر وضعیت">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                           </svg>
                           <span class="mr-1">' . $statusText . '</span>
                         </button>';
        }

        if (\Gate::allows(City::CITY_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                               data-city-id="' . $city->id . '"
                               data-city-name="' . htmlspecialchars($city->name) . '"
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
