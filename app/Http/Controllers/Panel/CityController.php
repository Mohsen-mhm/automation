<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CityStoreRequest;
use App\Http\Requests\Panel\CityUpdateRequest;
use App\Models\City;
use App\Models\Province;
use App\Services\CityService;
use App\Services\ProvinceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CityController extends Controller
{
    public function __construct(
        private CityService $cityService,
        private ProvinceService $provinceService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(City::CITY_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $cities = $this->cityService->getPaginatedCities([
                'search' => $request->get('search'),
                'province_id' => $request->get('province_id'),
                'status' => $request->get('status'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'cities' => $cities->items(),
                'pagination' => [
                    'current_page' => $cities->currentPage(),
                    'last_page' => $cities->lastPage(),
                    'per_page' => $cities->perPage(),
                    'total' => $cities->total()
                ]
            ]);
        }

        // Get provinces for filter dropdown
        $provinces = $this->provinceService->getActiveProvinces();

        return view('panel.cities.index', compact('provinces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(City::CITY_CREATE), 403);

        $provinces = $this->provinceService->getActiveProvinces();

        return response()->json([
            'success' => true,
            'html' => view('panel.cities.create', compact('provinces'))->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CityStoreRequest $request)
    {
        try {
            $city = $this->cityService->createCity($request->validated());

            if (!$city) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'شهر جدید با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.cities.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('City store error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در ثبت اطلاعات'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در ثبت اطلاعات')
                ->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(City $city)
    {
        abort_if(!Gate::allows(City::CITY_EDIT), 403);

        $provinces = $this->provinceService->getActiveProvinces();

        return response()->json([
            'success' => true,
            'html' => view('panel.cities.edit', compact('city', 'provinces'))->render(),
            'city_id' => $city->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CityUpdateRequest $request, City $city)
    {
        try {
            $success = $this->cityService->updateCity($city, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در بروزرسانی اطلاعات');
            }

            $message = 'اطلاعات شهر با موفقیت بروزرسانی شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.cities.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('City update error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در بروزرسانی اطلاعات'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در بروزرسانی اطلاعات')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        abort_if(!Gate::allows(City::CITY_DELETE), 403);

        try {
            $success = $this->cityService->deleteCity($city);

            if (!$success) {
                throw new \Exception('خطا در حذف شهر');
            }

            return response()->json([
                'success' => true,
                'message' => 'شهر با موفقیت حذف شد.'
            ]);

        } catch (\Exception $e) {
            \Log::error('City delete error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle city status
     */
    public function toggleStatus(City $city)
    {
        abort_if(!Gate::allows(City::CITY_EDIT), 403);

        try {
            $success = $this->cityService->toggleStatus($city);

            if (!$success) {
                throw new \Exception('خطا در تغییر وضعیت');
            }

            $statusText = $city->fresh()->active ? 'فعال' : 'غیرفعال';

            return response()->json([
                'success' => true,
                'message' => "وضعیت شهر به «{$statusText}» تغییر یافت."
            ]);

        } catch (\Exception $e) {
            \Log::error('City toggle status error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت'
            ], 500);
        }
    }

    /**
     * Get cities data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(City::CITY_INDEX), 403);

        try {
            $data = $this->cityService->getDataTablesData($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('DataTables error: ' . $e->getMessage());

            return response()->json([
                'draw' => (int) ($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'خطا در بارگذاری اطلاعات'
            ], 500);
        }
    }

    /**
     * Export cities to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(City::CITY_INDEX), 403);

        $search = $request->get('search');
        $provinceId = $request->get('province_id');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\CityExportService();

            if ($format === 'csv') {
                return $exportService->exportToCsv($search, $provinceId);
            }

            return $exportService->exportToExcel($search, $provinceId);

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در تولید فایل'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در تولید فایل');
        }
    }

    /**
     * Get cities by province (API)
     */
    public function getByProvince(Request $request, Province $province)
    {
        $cities = $this->cityService->getCitiesByProvince($province->id);

        return response()->json([
            'success' => true,
            'data' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                    'slug' => $city->slug
                ];
            })
        ]);
    }

    /**
     * Get cities for select options (API)
     */
    public function getOptions(Request $request)
    {
        $provinceId = $request->get('province_id');

        if ($provinceId) {
            $cities = $this->cityService->getCitiesByProvince($provinceId);
        } else {
            $cities = $this->cityService->getActiveCities();
        }

        return response()->json([
            'success' => true,
            'data' => $cities->map(function ($city) {
                return [
                    'id' => $city->id,
                    'name' => $city->name,
                    'province_name' => $city->province->name,
                    'full_name' => $city->full_name,
                    'slug' => $city->slug
                ];
            })
        ]);
    }
}
