<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\OrganizationStoreRequest;
use App\Http\Requests\Panel\OrganizationUpdateRequest;
use App\Models\OrganizationUser;
use App\Services\OrganizationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class OrganizationController extends Controller
{
    public function __construct(
        private OrganizationService $organizationService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(OrganizationUser::ORGAN_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $organizations = $this->organizationService->getPaginatedOrganizations([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'organizations' => $organizations->items(),
                'pagination' => [
                    'current_page' => $organizations->currentPage(),
                    'last_page' => $organizations->lastPage(),
                    'per_page' => $organizations->perPage(),
                    'total' => $organizations->total()
                ]
            ]);
        }

        $statuses = $this->organizationService->getStatuses();

        return view('panel.organizations.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_CREATE), 403);

        $data = $this->organizationService->prepareCreateData();

        return response()->json([
            'success' => true,
            'html' => view('panel.organizations.create-form', $data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrganizationStoreRequest $request)
    {
        try {
            $success = $this->organizationService->createOrganization($request->validated(), $request->allFiles());

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

            return redirect()->route('panel.organizations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Organization store error: ' . $e->getMessage());

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
    public function show(OrganizationUser $organization)
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_INDEX), 403);

        $organizationData = $this->organizationService->prepareShowData($organization);

        return response()->json([
            'success' => true,
            'html' => view('panel.organizations.show', $organizationData)->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OrganizationUser $organization)
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_EDIT), 403);

        $data = $this->organizationService->prepareEditData($organization);

        return response()->json([
            'success' => true,
            'html' => view('panel.organizations.edit-form', $data)->render(),
            'organization_id' => $organization->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(OrganizationUpdateRequest $request, OrganizationUser $organization)
    {
        try {
            $success = $this->organizationService->updateOrganization($organization, $request->validated(), $request->allFiles());

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

            return redirect()->route('panel.organizations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Organization update error: ' . $e->getMessage());

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
    public function destroy(OrganizationUser $organization)
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_DELETE), 403);

        try {
            $success = $this->organizationService->deleteOrganization($organization);

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

            return redirect()->route('panel.organizations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Organization delete error: ' . $e->getMessage());

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
     * Get organizations data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_INDEX), 403);

        try {
            $data = $this->organizationService->getDataTablesData($request->all());
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
     * Export organizations to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\OrganizationExportService();

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
     * Get statistics for dashboard
     */
    public function stats()
    {
        $stats = $this->organizationService->getStatistics();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
