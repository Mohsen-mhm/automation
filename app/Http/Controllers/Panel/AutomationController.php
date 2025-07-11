<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\AutomationStoreRequest;
use App\Http\Requests\Panel\AutomationUpdateRequest;
use App\Models\Automation;
use App\Services\AutomationExportService;
use App\Services\AutomationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AutomationController extends Controller
{
    public function __construct(
        private AutomationService $automationService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Automation::AUTOMATION_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $automations = $this->automationService->getPaginatedAutomations([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'automations' => $automations->items(),
                'pagination' => [
                    'current_page' => $automations->currentPage(),
                    'last_page' => $automations->lastPage(),
                    'per_page' => $automations->perPage(),
                    'total' => $automations->total()
                ]
            ]);
        }

        $statuses = $this->automationService->getStatuses();

        return view('panel.automations.index', compact('statuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_CREATE), 403);

        $data = $this->automationService->prepareCreateData();

        return response()->json([
            'success' => true,
            'html' => view('panel.automations.create-form', $data)->render()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AutomationStoreRequest $request)
    {
        try {
            $success = $this->automationService->createAutomation($request->validated());

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

            return redirect()->route('panel.automations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Automation store error: ' . $e->getMessage());

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
    public function show(Automation $automation)
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_INDEX), 403);

        $automationData = $this->automationService->prepareShowData($automation);

        return response()->json([
            'success' => true,
            'html' => view('panel.automations.show', $automationData)->render()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Automation $automation)
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_EDIT), 403);

        $data = $this->automationService->prepareEditData($automation);

        return response()->json([
            'success' => true,
            'html' => view('panel.automations.edit-form', $data)->render(),
            'automation_id' => $automation->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AutomationUpdateRequest $request, Automation $automation)
    {
        try {
            $success = $this->automationService->updateAutomation($automation, $request->validated());

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

            return redirect()->route('panel.automations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Automation update error: ' . $e->getMessage());

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
    public function destroy(Automation $automation)
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_DELETE), 403);

        try {
            $success = $this->automationService->deleteAutomation($automation);

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

            return redirect()->route('panel.automations.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Automation delete error: ' . $e->getMessage());

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
     * Get automations data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_INDEX), 403);

        try {
            $data = $this->automationService->getDataTablesData($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('DataTables error: ' . $e->getTraceAsString());

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
     * Export automations to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel');

        try {
            $exportService = new AutomationExportService();

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
        $stats = $this->automationService->getStatistics();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
