<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Http\Requests\Panel\AlertStoreRequest;
use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\Role;
use App\Services\AlertService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AlertController extends Controller
{
    public function __construct(
        private AlertService $alertService
    ) {
    }

    /**
     * Display alert settings for greenhouse owner
     */
    public function index(Request $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!auth()->user()->hasRole(Role::GREENHOUSE_ROLE), 403);

        $greenhouse = Greenhouse::where([
            'owner_national_id' => auth()->user()->getNationalId(),
            'owner_phone' => auth()->user()->getPhone()
        ])->first();

        if (!$greenhouse) {
            abort(404, 'گلخانه یافت نشد');
        }

        $alert = $greenhouse->alert;

        return view('panel.alerts.index', compact('greenhouse', 'alert'));
    }

    /**
     * Display alert settings for admin
     */
    public function admin(Request $request, $id)
    {

        $greenhouse = Greenhouse::findOrFail($id);
        $alert = $greenhouse->alert;

        return view('panel.alerts.admin', compact('greenhouse', 'alert', 'id'));
    }

    /**
     * Store alert settings for greenhouse owner
     */
    public function store(AlertStoreRequest $request)
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!auth()->user()->hasRole(Role::GREENHOUSE_ROLE), 403);

        try {
            $greenhouse = Greenhouse::where([
                'owner_national_id' => auth()->user()->getNationalId(),
                'owner_phone' => auth()->user()->getPhone()
            ])->first();

            if (!$greenhouse) {
                throw new \Exception('گلخانه یافت نشد');
            }

            $success = $this->alertService->updateAlert($greenhouse->alert, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'تنظیمات محدوده‌ها با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.alerts')
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Alert store error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Store alert settings for admin
     */
    public function storeAdmin(AlertStoreRequest $request, $id)
    {
        abort_if(!auth()->user()->isActive(), 403);

        try {
            $greenhouse = Greenhouse::findOrFail($id);

            $success = $this->alertService->updateAlert($greenhouse->alert, $request->validated());

            if (!$success) {
                throw new \Exception('خطا در ثبت اطلاعات');
            }

            $message = 'تنظیمات محدوده‌ها با موفقیت ثبت شد.';

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message
                ]);
            }

            return redirect()->route('panel.alerts.admin', $id)
                ->with('success', $message);

        } catch (\Exception $e) {
            \Log::error('Alert admin store error: ' . $e->getMessage());

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()
                ->with('error', $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Get alert statistics for dashboard
     */
    public function stats()
    {
        abort_if(!Gate::allows(GreenhouseAlert::ALERT_INDEX), 403);

        $stats = $this->alertService->getStatistics();

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }
}
