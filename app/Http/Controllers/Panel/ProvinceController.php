<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ProvinceStoreRequest;
use App\Http\Requests\Panel\ProvinceUpdateRequest;
use App\Models\Province;
use App\Services\ProvinceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ProvinceController extends Controller
{
    public function __construct(
        private ProvinceService $provinceService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Province::PROVINCE_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $provinces = $this->provinceService->getPaginatedProvinces([
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'provinces' => $provinces->items(),
                'pagination' => [
                    'current_page' => $provinces->currentPage(),
                    'last_page' => $provinces->lastPage(),
                    'per_page' => $provinces->perPage(),
                    'total' => $provinces->total()
                ]
            ]);
        }

        return view('panel.provinces.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(Province::PROVINCE_CREATE), 403);

        return response()->json([
            'success' => true,
            'html' => view('panel.provinces.create')->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProvinceStoreRequest $request)
    {
        try {
            $province = $this->provinceService->createProvince($request->validated());

            if (!$province) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'استان جدید با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.provinces.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Province store error: ' . $e->getMessage());

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
    public function edit(Province $province)
    {
        abort_if(!Gate::allows(Province::PROVINCE_EDIT), 403);

        return response()->json([
            'success' => true,
            'html' => view('panel.provinces.edit', compact('province'))->render(),
            'province_id' => $province->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProvinceUpdateRequest $request, Province $province)
    {
        try {
            $success = $this->provinceService->updateProvince($province, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در بروزرسانی اطلاعات');
            }

            $message = 'اطلاعات استان با موفقیت بروزرسانی شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.provinces.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Province update error: ' . $e->getMessage());

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
    public function destroy(Province $province)
    {
        abort_if(!Gate::allows(Province::PROVINCE_DELETE), 403);

        try {
            $success = $this->provinceService->deleteProvince($province);

            if (!$success) {
                throw new \Exception('خطا در حذف استان');
            }

            return response()->json([
                'success' => true,
                'message' => 'استان با موفقیت حذف شد.'
            ]);

        } catch (\Exception $e) {
            \Log::error('Province delete error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Toggle province status
     */
    public function toggleStatus(Province $province)
    {
        abort_if(!Gate::allows(Province::PROVINCE_EDIT), 403);

        try {
            $success = $this->provinceService->toggleStatus($province);

            if (!$success) {
                throw new \Exception('خطا در تغییر وضعیت');
            }

            $statusText = $province->fresh()->active ? 'فعال' : 'غیرفعال';

            return response()->json([
                'success' => true,
                'message' => "وضعیت استان به «{$statusText}» تغییر یافت."
            ]);

        } catch (\Exception $e) {
            \Log::error('Province toggle status error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت'
            ], 500);
        }
    }

    /**
     * Get provinces data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Province::PROVINCE_INDEX), 403);

        try {
            $data = $this->provinceService->getDataTablesData($request->all());
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
     * Export provinces to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Province::PROVINCE_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\ProvinceExportService();

            if ($format === 'csv') {
                return $exportService->exportToCsv($search);
            }

            return $exportService->exportToExcel($search);

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
     * Get provinces for select options (API)
     */
    public function getOptions(Request $request)
    {
        $provinces = $this->provinceService->getActiveProvinces();

        return response()->json([
            'success' => true,
            'data' => $provinces->map(function ($province) {
                return [
                    'id' => $province->id,
                    'name' => $province->name,
                    'slug' => $province->slug
                ];
            })
        ]);
    }
}
