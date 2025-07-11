<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\ConfigUpdateRequest;
use App\Models\Config;
use App\Services\ConfigService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigController extends Controller
{
    public function __construct(
        private ConfigService $configService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Config::CONFIG_INDEX), 403);

        // Get filters data
        $filters = $this->configService->getAllFilters();
        $activeFilters = $this->configService->getActiveFilters()->pluck('uuid')->toArray();

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $configs = $this->configService->getPaginatedConfigs([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'configs' => $configs->items(),
                'pagination' => [
                    'current_page' => $configs->currentPage(),
                    'last_page' => $configs->lastPage(),
                    'per_page' => $configs->perPage(),
                    'total' => $configs->total()
                ]
            ]);
        }

        return view('panel.configs.index', compact('filters', 'activeFilters'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Config $config)
    {
        abort_if(!Gate::allows(Config::CONFIG_EDIT), 403);

        $configData = $this->configService->prepareConfigForEdit($config);

        // Return appropriate view based on config type
        if ($configData['is_json_type']) {
            return response()->json([
                'success' => true,
                'html' => view('panel.configs.edit-forms.json', $configData)->render(),
                'config_id' => $config->id,
                'config_type' => 'json'
            ]);
        }

        return response()->json([
            'success' => true,
            'html' => view('panel.configs.edit-forms.string', $configData)->render(),
            'config_id' => $config->id,
            'config_type' => 'string'
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ConfigUpdateRequest $request, Config $config)
    {
        try {
            $success = $this->configService->updateConfig($config, $request->validated());

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

            return redirect()->route('panel.configs.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Config update error: ' . $e->getMessage());

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
     * Update filters status
     */
    public function updateFilters(Request $request)
    {
        $request->validate([
            'filters' => 'array',
            'filters.*' => 'string|exists:filters,uuid'
        ]);

        try {
            $activeFilters = $request->get('filters', []);
            $success = $this->configService->updateFiltersStatus($activeFilters);

            if (!$success) {
                throw new \Exception('خطا در بروزرسانی فیلترها');
            }

            $message = 'فیلتر ها با موفقیت آپدیت شدند.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.configs.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Filters update error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در بروزرسانی فیلترها'
                ], 500);
            }

            return redirect()->back()
                ->with('error', 'خطا در بروزرسانی فیلترها');
        }
    }

    /**
     * Get configs data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Config::CONFIG_INDEX), 403);

        try {
            $data = $this->configService->getDataTablesData($request->all());
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
     * Export configs to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Config::CONFIG_INDEX), 403);

        $search = $request->get('search');
        $format = $request->get('format', 'excel'); // excel or csv

        try {
            $exportService = new \App\Services\ConfigExportService();

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
}
