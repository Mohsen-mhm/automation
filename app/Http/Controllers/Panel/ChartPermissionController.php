<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\ChartPermission;
use App\Models\Role;
use App\Services\ChartPermissionService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChartPermissionController extends Controller
{
    protected ChartPermissionService $chartPermissionService;

    public function __construct(ChartPermissionService $chartPermissionService)
    {
        $this->chartPermissionService = $chartPermissionService;
    }

    /**
     * Display chart permissions management
     */
    public function index()
    {
        abort_if(!auth()->user()->hasRole(Role::ADMIN_ROLE), 403);

        $chartPermissions = $this->chartPermissionService->getChartPermissionsGrouped();
        $categories = ChartPermission::getCategories();

        return view('panel.chart-permissions.index', compact('chartPermissions', 'categories'));
    }

    /**
     * Update chart permissions
     */
    public function update(Request $request)
    {
        abort_if(!auth()->user()->hasRole(Role::ADMIN_ROLE), 403);

        $request->validate([
            'permissions' => 'required|array',
            'permissions.*' => 'array',
            'permissions.*.company' => 'boolean',
            'permissions.*.greenhouse' => 'boolean',
            'permissions.*.organization' => 'boolean',
        ]);

        try {
            $success = $this->chartPermissionService->bulkUpdatePermissions($request->permissions);

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'تنظیمات نمودارها با موفقیت ذخیره شد'
                ]);
            } else {
                throw new Exception('خطا در ذخیره تنظیمات');
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در ذخیره تنظیمات'
            ], 500);
        }
    }

    /**
     * Toggle specific chart permission
     */
    public function toggle(Request $request)
    {
        abort_if(!auth()->user()->hasRole(Role::ADMIN_ROLE), 403);

        $request->validate([
            'chart_key' => 'required|exists:chart_permissions,chart_key',
            'role' => 'required|in:company,greenhouse,organization',
            'visible' => 'required|boolean'
        ]);

        try {
            $success = $this->chartPermissionService->updateChartPermission(
                $request->chart_key,
                $request->role,
                $request->visible
            );

            if ($success) {
                return response()->json([
                    'success' => true,
                    'message' => 'تنظیمات با موفقیت تغییر کرد'
                ]);
            } else {
                throw new Exception('خطا در تغییر تنظیمات');
            }
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر تنظیمات'
            ], 500);
        }
    }
}
