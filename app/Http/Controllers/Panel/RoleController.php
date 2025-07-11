<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\RoleUpdateRequest;
use App\Models\Role;
use App\Models\Permission;
use App\Services\RoleService;
use App\Services\ExportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function __construct(
        private RoleService   $roleService,
        private ExportService $exportService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Role::ROLE_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $roles = $this->roleService->getPaginatedRoles([
                'search' => $request->get('search'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'roles' => $roles->items(),
                'pagination' => [
                    'current_page' => $roles->currentPage(),
                    'last_page' => $roles->lastPage(),
                    'per_page' => $roles->perPage(),
                    'total' => $roles->total()
                ]
            ]);
        }

        return view('panel.roles.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_ASSIGN), 403);

        try {
            $roleData = $this->roleService->prepareRoleForEdit($role);

            return response()->json([
                'success' => true,
                ...$roleData
            ]);
        } catch (\Exception $e) {
            \Log::error('Role edit error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در بارگذاری اطلاعات نقش'
            ], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleUpdateRequest $request, Role $role)
    {
        try {
            $success = $this->roleService->updateRolePermissions($role, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $permissionsCount = count($request->validated()['permissions'] ?? []);
            $message = "دسترسی‌های نقش «{$role->title}» با موفقیت بروزرسانی شد. ({$permissionsCount} دسترسی تخصیص یافت)";

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'role_id' => $role->id,
                        'permissions_count' => $permissionsCount
                    ]
                ]);
            }

            return redirect()->route('panel.roles')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Role permissions update error: ' . $e->getMessage(), [
                'role_id' => $role->id,
                'user_id' => auth()->id(),
                'permissions' => $request->validated()['permissions'] ?? []
            ]);

            $errorMessage = 'خطا در بروزرسانی دسترسی‌های نقش';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage,
                    'error' => config('app.debug') ? $e->getMessage() : null
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }

    /**
     * Get roles data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(Role::ROLE_INDEX), 403);

        try {
            $data = $this->roleService->getDataTablesData($request->all());
            return response()->json($data);
        } catch (\Exception $e) {
            \Log::error('Roles data retrieval error: ' . $e->getMessage());

            return response()->json([
                'draw' => intval($request->get('draw', 1)),
                'recordsTotal' => 0,
                'recordsFiltered' => 0,
                'data' => [],
                'error' => 'خطا در بارگذاری اطلاعات'
            ], 500);
        }
    }

    /**
     * Export roles to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(Role::ROLE_INDEX), 403);

        $request->validate([
            'format' => 'nullable|string|in:excel,csv'
        ]);

        try {
            $format = $request->get('format', 'excel');

            \Log::info('Role export initiated', [
                'user_id' => auth()->id(),
                'format' => $format,
                'timestamp' => now()
            ]);

            return $this->exportService->exportRoles($format);

        } catch (\Exception $e) {
            \Log::error('Role export error: ' . $e->getMessage(), [
                'user_id' => auth()->id(),
                'format' => $request->get('format', 'excel'),
                'stack_trace' => $e->getTraceAsString()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'خطا در صادرات فایل. لطفا مجدداً تلاش کنید.'
                ], 500);
            }

            return redirect()->back()->with('error', 'خطا در صادرات فایل. لطفا مجدداً تلاش کنید.');
        }
    }

    /**
     * Get role statistics
     */
    public function getStats(Request $request)
    {
        abort_if(!Gate::allows(Role::ROLE_INDEX), 403);

        try {
            $stats = $this->roleService->getRoleStats();

            return response()->json([
                'success' => true,
                'stats' => $stats
            ]);
        } catch (\Exception $e) {
            \Log::error('Role stats error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در بارگذاری آمار'
            ], 500);
        }
    }

    /**
     * Get role details with permissions
     */
    public function show(Role $role)
    {
        abort_if(!Gate::allows(Role::ROLE_INDEX), 403);

        try {
            $role->load('permissions');

            return response()->json([
                'success' => true,
                'role' => [
                    'id' => $role->id,
                    'title' => $role->title,
                    'guard_name' => $role->guard_name,
                    'permissions_count' => $role->permissions->count(),
                    'permissions' => $role->permissions->map(function ($permission) {
                        return [
                            'id' => $permission->id,
                            'title' => $permission->title,
                            'name' => $permission->name
                        ];
                    }),
                    'created_at' => $role->created_at?->format('Y-m-d H:i:s'),
                    'updated_at' => $role->updated_at?->format('Y-m-d H:i:s')
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Role show error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در بارگذاری اطلاعات نقش'
            ], 500);
        }
    }

    /**
     * Bulk assign permissions to multiple roles
     */
    public function bulkAssignPermissions(Request $request)
    {
        abort_if(!Gate::allows(Permission::PERMISSION_ASSIGN), 403);

        $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'integer|exists:roles,id',
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'integer|exists:permissions,id',
            'action' => 'required|string|in:assign,revoke'
        ]);

        try {
            $result = $this->roleService->bulkUpdatePermissions(
                $request->role_ids,
                $request->permission_ids,
                $request->action
            );

            $action = $request->action === 'assign' ? 'تخصیص' : 'لغو تخصیص';
            $message = "عملیات {$action} دسترسی‌ها برای " . count($request->role_ids) . " نقش با موفقیت انجام شد.";

            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $result
            ]);

        } catch (\Exception $e) {
            \Log::error('Bulk assign permissions error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در انجام عملیات گروهی'
            ], 500);
        }
    }

    /**
     * Clone role with all permissions
     */
    public function clone(Role $role, Request $request)
    {
        abort_if(!Gate::allows(Role::ROLE_INDEX ?? 'roles.create'), 403);

        $request->validate([
            'title' => 'required|string|max:255|unique:roles,title'
        ]);

        try {
            $newRole = $this->roleService->cloneRole($role, $request->title);

            $message = "نقش «{$newRole->title}» با موفقیت از «{$role->title}» کپی شد.";

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'data' => [
                        'new_role_id' => $newRole->id,
                        'permissions_count' => $newRole->permissions()->count()
                    ]
                ]);
            }

            return redirect()->route('panel.roles')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Role clone error: ' . $e->getMessage());

            $errorMessage = 'خطا در کپی کردن نقش';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 500);
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
}
