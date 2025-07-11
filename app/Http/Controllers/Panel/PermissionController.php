<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Services\PermissionService;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PermissionController extends Controller
{
    public function __construct(
        private PermissionService $permissionService,
        private ExportService     $exportService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Permission::PERMISSION_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $permissions = $this->permissionService->getPaginatedPermissions([
                'search' => $request->get('search'),
                'category' => $request->get('category'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'permissions' => $permissions->items(),
                'pagination' => [
                    'current_page' => $permissions->currentPage(),
                    'last_page' => $permissions->lastPage(),
                    'per_page' => $permissions->perPage(),
                    'total' => $permissions->total()
                ]
            ]);
        }

        return view('panel.permissions.index');
    }

    /**
     * Get permission details
     */
    public function show(Permission $permission)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_INDEX), 403);

        $details = $this->permissionService->getPermissionDetails($permission->id);

        return response()->json([
            'success' => true,
            'permission' => $details
        ]);
    }

    /**
     * Get permissions data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_INDEX), 403);

        $data = $this->permissionService->getDataTablesData($request->all());

        return response()->json($data);
    }

    /**
     * Export permissions to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_INDEX), 403);

        try {
            $format = $request->get('format', 'excel');
            return $this->exportService->exportPermissions($format);
        } catch (\Exception $e) {
            \Log::error('Permission export error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در صادرات فایل'
                ], 500);
            }

            return redirect()->back()->with('error', 'خطا در صادرات فایل');
        }
    }

    /**
     * Get permission statistics
     */
    public function getStats(Request $request)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_INDEX), 403);

        $stats = $this->permissionService->getPermissionStats();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
