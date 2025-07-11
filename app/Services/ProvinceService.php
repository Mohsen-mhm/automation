<?php

namespace App\Services;

use App\Models\Province;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProvinceService
{
    /**
     * Get paginated provinces with search and filtering
     */
    public function getPaginatedProvinces(array $filters = []): LengthAwarePaginator
    {
        $query = Province::with('cities');

        // Apply search filter
        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('active', (bool)$filters['status']);
        }

        // Default sorting
        $query->orderBy('sort_order')->orderBy('name');

        // Get pagination settings
        $perPage = $filters['per_page'] ?? 15;

        return $query->paginate($perPage);
    }

    /**
     * Create new province
     */
    public function createProvince(array $data): Province
    {
        // Set sort order if not provided
        if (!isset($data['sort_order'])) {
            $data['sort_order'] = Province::max('sort_order') + 1;
        }

        return Province::create($data);
    }

    /**
     * Update province
     */
    public function updateProvince(Province $province, array $data): bool
    {
        return $province->update($data);
    }

    /**
     * Delete province (with cities check)
     */
    public function deleteProvince(Province $province): bool
    {
        // Check if province has cities
        if ($province->cities()->count() > 0) {
            throw new \Exception('این استان دارای شهر می‌باشد و قابل حذف نیست.');
        }

        return $province->delete();
    }

    /**
     * Toggle province status
     */
    public function toggleStatus(Province $province): bool
    {
        return $province->update(['active' => !$province->active]);
    }

    /**
     * Get all active provinces
     */
    public function getActiveProvinces(): Collection
    {
        return Province::active()->ordered()->get();
    }

    /**
     * Get DataTables formatted data
     */
    public function getDataTablesData(array $request): array
    {
        $query = Province::withCount('cities');

        // Handle search
        if (!empty($request['search']['value'])) {
            $searchValue = $request['search']['value'];
            $query->where('name', 'like', '%' . $searchValue . '%');
        }

        // Handle status filter
        if (isset($request['status']) && $request['status'] !== '') {
            $query->where('active', (bool)$request['status']);
        }

        // Default sorting
        $query->orderBy('sort_order')->orderBy('name');

        $totalRecords = Province::count();
        $filteredRecords = $query->count();

        // Pagination
        $start = (int)($request['start'] ?? 0);
        $length = (int)($request['length'] ?? 10);

        // Handle "show all" case
        if ($length == -1) {
            $provinces = $query->get();
        } else {
            $provinces = $query->skip($start)->take($length)->get();
        }

        $data = [];
        foreach ($provinces as $index => $province) {
            $rowIndex = $start + $index + 1;

            $data[] = [
                $rowIndex,
                $province->name,
                $province->cities_count,
                $this->generateStatusBadge($province->active),
                $province->sort_order,
                $province->created_at->format('Y/m/d H:i'),
                $this->generateActionButtons($province)
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
    private function generateActionButtons(Province $province): string
    {
        $buttons = '';

        if (\Gate::allows(Province::PROVINCE_EDIT)) {
            $buttons .= '<button class="btn-edit inline-flex items-center px-3 py-1.5 text-xs font-medium text-blue-600 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors duration-200 ml-2"
                               data-province-id="' . $province->id . '"
                               title="ویرایش">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                           </svg>
                           <span class="mr-1">ویرایش</span>
                         </button>';

            $statusText = $province->active ? 'غیرفعال' : 'فعال';
            $statusColor = $province->active ? 'orange' : 'emerald';
            $buttons .= '<button class="btn-toggle inline-flex items-center px-3 py-1.5 text-xs font-medium text-' . $statusColor . '-600 hover:text-' . $statusColor . '-800 bg-' . $statusColor . '-50 hover:bg-' . $statusColor . '-100 rounded-lg transition-colors duration-200 ml-2"
                               data-province-id="' . $province->id . '"
                               title="تغییر وضعیت">
                           <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9l4-4 4 4m0 6l-4 4-4-4"/>
                           </svg>
                           <span class="mr-1">' . $statusText . '</span>
                         </button>';
        }

        if (\Gate::allows(Province::PROVINCE_DELETE)) {
            $buttons .= '<button class="btn-delete inline-flex items-center px-3 py-1.5 text-xs font-medium text-red-600 hover:text-red-800 bg-red-50 hover:bg-red-100 rounded-lg transition-colors duration-200"
                               data-province-id="' . $province->id . '"
                               data-province-name="' . htmlspecialchars($province->name) . '"
                               data-cities-count="' . $province->cities_count . '"
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
