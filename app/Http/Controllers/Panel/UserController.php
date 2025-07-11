<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\UserUpdateRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(User::USER_INDEX), 403);

        // For AJAX requests, return JSON
        if ($request->ajax()) {
            $users = $this->userService->getPaginatedUsers([
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'role' => $request->get('role'),
                'per_page' => $request->get('per_page', 15)
            ]);

            return response()->json([
                'users' => $users->items(),
                'pagination' => [
                    'current_page' => $users->currentPage(),
                    'last_page' => $users->lastPage(),
                    'per_page' => $users->perPage(),
                    'total' => $users->total()
                ]
            ]);
        }

        // Get filter options
        $roles = $this->userService->getAllRoles();
        $stats = $this->userService->getUserStats();

        return view('panel.users.index', compact('roles', 'stats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        abort_if(!Gate::allows(User::USER_EDIT), 403);

        $userData = $this->userService->prepareUserForEdit($user);

        return response()->json([
            'success' => true,
            'html' => view('panel.users.edit-form', $userData)->render(),
            'user_id' => $user->id
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $success = $this->userService->updateUser($user, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'اطلاعات کاربر با موفقیت بروزرسانی شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.users.index')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('User update error: ' . $e->getMessage());

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
     * Toggle user status (active/inactive)
     */
    public function toggleStatus(User $user)
    {
        abort_if(!Gate::allows(User::USER_EDIT), 403);

        try {
            $newStatus = !$user->active;
            $user->update(['active' => $newStatus]);

            $message = $newStatus ? 'کاربر فعال شد.' : 'کاربر غیرفعال شد.';

            return response()->json([
                'success' => true,
                'message' => $message,
                'new_status' => $newStatus
            ]);

        } catch (\Exception $e) {
            \Log::error('User status toggle error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'خطا در تغییر وضعیت کاربر'
            ], 500);
        }
    }

    /**
     * Get users data for DataTables
     */
    public function getData(Request $request)
    {
        abort_if(!Gate::allows(User::USER_INDEX), 403);

        try {
            $data = $this->userService->getDataTablesData($request->all());
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
     * Export users to Excel/CSV
     */
    public function export(Request $request)
    {
        abort_if(!Gate::allows(User::USER_INDEX), 403);

        try {
            $filters = [
                'search' => $request->get('search'),
                'status' => $request->get('status'),
                'role' => $request->get('role'),
            ];

            // Remove empty filters
            $filters = array_filter($filters);

            $exportService = new \App\Services\SimpleExportService();
            $users = $exportService->getUsersForExport($filters);

            if ($users->isEmpty()) {
                return redirect()->back()->with('error', 'هیچ کاربری برای صادرات یافت نشد.');
            }

            $format = $request->get('format', 'csv');

            if ($format === 'html') {
                // Export as HTML table (Excel can open this)
                $content = $exportService->createExcelHtmlContent($users);
                $filename = $exportService->generateFilename('xls');

                return response($content)
                    ->header('Content-Type', 'application/vnd.ms-excel; charset=utf-8')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'max-age=0');
            } else {
                // Export as CSV (Excel compatible)
                $content = $exportService->createExcelCsvContent($users);
                $filename = $exportService->generateFilename('csv');

                return response($content)
                    ->header('Content-Type', 'text/csv; charset=utf-8')
                    ->header('Content-Disposition', 'attachment; filename="' . $filename . '"')
                    ->header('Cache-Control', 'max-age=0');
            }

        } catch (\Exception $e) {
            \Log::error('Export error: ' . $e->getMessage());

            return redirect()->back()->with('error', 'خطا در صادرات اطلاعات');
        }
    }
}
