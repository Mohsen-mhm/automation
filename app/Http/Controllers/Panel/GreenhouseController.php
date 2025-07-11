<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\GreenhouseStoreRequest;
use App\Http\Requests\Panel\GreenhouseUpdateRequest;
use App\Models\Greenhouse;
use App\Models\Province;
use App\Services\GreenhouseService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GreenhouseController extends Controller
{
    public function __construct(
        private GreenhouseService $greenhouseService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $greenhouses = $this->greenhouseService->getPaginatedGreenhouses([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'greenhouses' => $greenhouses->items(),
                'pagination' => [
                    'current_page' => $greenhouses->currentPage(),
                    'last_page' => $greenhouses->lastPage(),
                    'per_page' => $greenhouses->perPage(),
                    'total' => $greenhouses->total()
                ]
            ]);
        }

        $substrates = $this->greenhouseService->getSubstrates();
        $productTypes = $this->greenhouseService->getProductTypes();
        $greenhouseStatuses = $this->greenhouseService->getGreenhouseStatuses();
        $statuses = $this->greenhouseService->getStatuses();

        return view('panel.greenhouses.index', compact(
            'substrates',
            'productTypes',
            'greenhouseStatuses',
            'statuses'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_CREATE), 403);

        $data = $this->greenhouseService->prepareCreateData();

        return response()->json([
            'success' => true,
            'html' => view('panel.greenhouses.create-form', $data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(GreenhouseStoreRequest $request)
    {
        try {
            $success = $this->greenhouseService->createGreenhouse($request->validated(), $request->allFiles());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'اطلاعات با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.greenhouses.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Greenhouse store error: ' . $e->getMessage());

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
     * Display the specified resource.
     */
    public function show(Greenhouse $greenhouse)
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_INDEX), 403);

        $greenhouseData = $this->greenhouseService->prepareShowData($greenhouse);

        return response()->json([
            'success' => true,
            'html' => view('panel.greenhouses.show', $greenhouseData)->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Greenhouse $greenhouse)
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_EDIT), 403);

        $data = $this->greenhouseService->prepareEditData($greenhouse);

        return response()->json([
            'success' => true,
            'html' => view('panel.greenhouses.edit-form', $data)->render(),
            'greenhouse_id' => $greenhouse->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(GreenhouseUpdateRequest $request, Greenhouse $greenhouse)
    {
        try {
            $success = $this->greenhouseService->updateGreenhouse($greenhouse, $request->validated(), $request->allFiles());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'اطلاعات با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.greenhouses.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Greenhouse update error: ' . $e->getMessage());

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
     * Remove the specified resource from storage.
     */
    public function destroy(Greenhouse $greenhouse)
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_DELETE), 403);

        try {
            $success = $this->greenhouseService->deleteGreenhouse($greenhouse);

            if (!$success) {
                throw new \Exception('خطا در حذف اطلاعات');
            }

            $message = 'اطلاعات با موفقیت حذف شد.';

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.greenhouses.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Greenhouse delete error: ' . $e->getMessage());

            if (request()->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در حذف اطلاعات'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در حذف اطلاعات');
        }
    }

    /**
     * Get greenhouses data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_INDEX), 403);

        try {
            $data = $this->greenhouseService->getDataTablesData($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('DataTables error: ' . $e->getMessage());

            return response()->json([
                'draw' => (int)($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'خطا در بارگذاری اطلاعات'
            ], 500);
        }
    }

    /**
     * Export greenhouses to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel');

        try {
            $exportService = new \App\Services\GreenhouseExportService();

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
     * Get coordinates from Google Maps link
     */
    public function getCoordinates(Request $request)
    {
        $request->validate([
            'url' => 'required|string|url'
        ]);

        try {
            $coordinates = $this->greenhouseService->extractCoordinatesFromUrl($request->url);

            return response()->json([
                'success' => true,
                'coordinates' => $coordinates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت مختصات: ' . $e->getMessage()
            ], 400);
        }
    }

    /**
     * Get provinces for select dropdown
     */
    public function getProvinces()
    {
        $provinces = $this->greenhouseService->getProvinces();

        return response()->json([
            'success' => true,
            'provinces' => $provinces
        ]);
    }

    /**
     * Get cities by province for select dropdown
     */
    public function getCitiesByProvince($province)
    {
        // If $province is a numeric ID, use it directly
        // If it's a province name, find the province first
        if (is_numeric($province)) {
            $cities = $this->greenhouseService->getCitiesByProvince($province);
        } else {
            // Find province by name and get its cities
            $provinceModel = Province::where('name', $province)->first();
            if (!$provinceModel) {
                return response()->json([
                    'success' => false,
                    'message' => 'استان یافت نشد'
                ], 404);
            }
            $cities = $this->greenhouseService->getCitiesByProvince($provinceModel->id);
        }

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    /**
     * Get statistics for dashboard
     */
    public function stats()
    {
        $stats = $this->greenhouseService->getStatistics();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
