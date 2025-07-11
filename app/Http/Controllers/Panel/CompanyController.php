<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\CompanyStoreRequest;
use App\Http\Requests\Panel\CompanyUpdateRequest;
use App\Models\Company;
use App\Services\CompanyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CompanyController extends Controller
{
    public function __construct(
        private CompanyService $companyService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $companies = $this->companyService->getPaginatedCompanies([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'companies' => $companies->items(),
                'pagination' => [
                    'current_page' => $companies->currentPage(),
                    'last_page' => $companies->lastPage(),
                    'per_page' => $companies->perPage(),
                    'total' => $companies->total()
                ]
            ]);
        }

        $companyTypes = $this->companyService->getCompanyTypes();
        $statuses = $this->companyService->getStatuses();

        return view('panel.companies.index', compact('companyTypes', 'statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(Company::COMPANY_CREATE), 403);

        $data = $this->companyService->prepareCreateData();

        return response()->json([
            'success' => true,
            'html' => view('panel.companies.create-form', $data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyStoreRequest $request)
    {
        try {
            $success = $this->companyService->createCompany($request->validated(), $request->allFiles());

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

            return redirect()->route('panel.companies.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Company store error: ' . $e->getMessage());

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
    public function show(Company $company)
    {
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);

        $companyData = $this->companyService->prepareShowData($company);

        return response()->json([
            'success' => true,
            'html' => view('panel.companies.show', $companyData)->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        abort_if(!Gate::allows(Company::COMPANY_EDIT), 403);

        $data = $this->companyService->prepareEditData($company);

        return response()->json([
            'success' => true,
            'html' => view('panel.companies.edit-form', $data)->render(),
            'company_id' => $company->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, Company $company)
    {
        try {
            $success = $this->companyService->updateCompany($company, $request->validated(), $request->allFiles());

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

            return redirect()->route('panel.companies.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Company update error: ' . $e->getMessage());

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
    public function destroy(Company $company)
    {
        abort_if(!Gate::allows(Company::COMPANY_DELETE), 403);

        try {
            $success = $this->companyService->deleteCompany($company);

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

            return redirect()->route('panel.companies.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Company delete error: ' . $e->getMessage());

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
     * Get companies data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);

        try {
            $data = $this->companyService->getDataTablesData($request->all());
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
     * Export companies to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\CompanyExportService();

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
     * Get provinces for select dropdown
     */
    public function getProvinces()
    {
        $provinces = $this->companyService->getProvinces();

        return response()->json([
            'success' => true,
            'provinces' => $provinces
        ]);
    }

    /**
     * Get cities by province for select dropdown
     */
    public function getCities(Request $request)
    {
        $cities = $this->companyService->getAllCities();

        return response()->json([
            'success' => true,
            'cities' => $cities
        ]);
    }

    /**
     * Get cities by province for select dropdown
     */
    public function getCitiesByProvince($province)
    {
        $cities = $this->companyService->getCitiesByProvince($province);

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
        $stats = $this->companyService->getStatistics();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
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
            $coordinates = $this->companyService->extractCoordinatesFromUrl($request->url);

            return response()->json([
                'success' => true,
                'coordinates' => $coordinates
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در دریافت مختصات' . $e->getMessage()
            ], 400);
        }
    }
}
