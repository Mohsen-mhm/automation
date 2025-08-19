<?php

namespace App\Http\Controllers\Panel;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\Automation;
use App\Models\Province;
use App\Services\ChartPermissionService;
use App\Services\SMS\smsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    protected ChartPermissionService $chartPermissionService;

    public function __construct(ChartPermissionService $chartPermissionService)
    {
        $this->chartPermissionService = $chartPermissionService;
    }

    public function index()
    {
        // Check if user is active
        if (!auth()->user()->isActive()) {
            return view('panel.dashboard.index', [
                'isUserActive' => false
            ]);
        }

        $data = [
            'isUserActive' => true,
            'credit' => $this->getSmsCredit(),
        ];

        // Get visible charts for current user
        $visibleCharts = $this->chartPermissionService->getVisibleChartsForUser();

        // Only load data for visible charts
        $chartData = [];
        foreach ($visibleCharts as $chartKey) {
            $chartData[$chartKey] = $this->getChartData($chartKey);
        }

        $data['chartData'] = $chartData;
        $data['visibleCharts'] = $visibleCharts;

        // Add chart management for admin
        if (auth()->user()->hasRole(\App\Models\Role::ADMIN_ROLE)) {
            $data['statsCards'] = $this->getStatsCards();
            $data['canManageCharts'] = true;
        }

        return view('panel.dashboard.index', $data);
    }

    /**
     * Get chart data by chart key
     */
    private function getChartData(string $chartKey)
    {
        return match($chartKey) {
            'users_count' => $this->getUsersCount(),
            'company_per_province' => $this->getCompanyPerProvince(),
            'greenhouse_per_province' => $this->getGreenhousePerProvince(),
            'climate_automation_per_company' => $this->getClimateAutomationPerCompany(),
            'feeding_automation_per_company' => $this->getFeedingAutomationPerCompany(),
            'greenhouses_by_area' => $this->getGreenhousesByArea(),
            'greenhouses_by_product' => $this->getGreenhousesByProduct(),
            'greenhouses_by_climate_control' => $this->getGreenhousesByClimateControl(),
            'greenhouses_by_feeding_control' => $this->getGreenhousesByFeedingControl(),
            'greenhouses_by_company_climate' => $this->getGreenhousesByCompanyClimate(),
            'greenhouses_by_company_feeding' => $this->getGreenhousesByCompanyFeeding(),
            'registered_vs_linked_greenhouses' => $this->getRegisteredVsLinkedGreenhouses(),
            'greenhouse_area_by_province' => $this->getGreenhouseAreaByProvince(),
            'server_connected_greenhouses' => $this->getServerConnectedGreenhouses(),
            default => []
        };
    }

    private function getSmsCredit()
    {
        try {
            return smsService::getCredit();
        } catch (\Exception $e) {
            return 'خطا در دریافت اطلاعات';
        }
    }

    private function getStatsCards()
    {
        return [
            'totalUsers' => \App\Models\User::count(),
            'totalCompanies' => Company::count(),
            'activeCompanies' => Company::where('active', true)->count(),
            'totalGreenhouses' => Greenhouse::count(),
            'activeGreenhouses' => Greenhouse::where('active', true)->count(),
            'totalOrganization' => OrganizationUser::count(),
            'activeOrganization' => OrganizationUser::where('active', true)->count(),
            'totalAutomations' => Automation::count(),
            'activeAutomations' => Automation::where('active', true)->count(),
            'organizationUsers' => OrganizationUser::count(),
        ];
    }

    private function getCompanyPerProvince()
    {
        return Company::join('provinces', 'companies.province_id', '=', 'provinces.id')
            ->select('provinces.name as province_name', DB::raw('COUNT(*) as count'))
            ->groupBy('provinces.id', 'provinces.name')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->province_name,
                    'count' => (int)$item->count, // Ensure integer
                    'color' => $this->generateRandomColor()
                ];
            })
            ->values(); // Reset array keys
    }

    private function getGreenhousePerProvince()
    {
        return Greenhouse::join('provinces', 'greenhouses.province_id', '=', 'provinces.id')
            ->select('provinces.name as province_name', DB::raw('COUNT(*) as count'))
            ->groupBy('provinces.id', 'provinces.name')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->province_name,
                    'count' => (int)$item->count, // Ensure integer
                    'color' => $this->generateRandomColor()
                ];
            })
            ->values(); // Reset array keys
    }

    private function getUsersCount()
    {
        return [
            [
                'name' => 'کاربران سازمانی',
                'count' => (int)OrganizationUser::count(),
                'color' => '#3B82F6'
            ],
            [
                'name' => 'شرکت‌ها',
                'count' => (int)Company::count(),
                'color' => '#10B981'
            ],
            [
                'name' => 'گلخانه‌ها',
                'count' => (int)Greenhouse::count(),
                'color' => '#F59E0B'
            ]
        ];
    }

    private function getClimateAutomationPerCompany()
    {
        $results = DB::table('companies')
            ->join('automations', 'companies.id', '=', 'automations.climate_company_id')
            ->select('companies.name', DB::raw('COUNT(automations.id) as automation_count'))
            ->groupBy('companies.id', 'companies.name')
            ->havingRaw('COUNT(automations.id) > 0')
            ->orderByDesc('automation_count')
            ->get();

        return $results->map(function ($company) {
            return [
                'name' => $company->name,
                'count' => (int)$company->automation_count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getFeedingAutomationPerCompany()
    {
        $results = DB::table('companies')
            ->join('automations', 'companies.id', '=', 'automations.feeding_company_id')
            ->select('companies.name', DB::raw('COUNT(automations.id) as automation_count'))
            ->groupBy('companies.id', 'companies.name')
            ->havingRaw('COUNT(automations.id) > 0')
            ->orderByDesc('automation_count')
            ->get();

        return $results->map(function ($company) {
            return [
                'name' => $company->name,
                'count' => (int)$company->automation_count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getGreenhousesByArea()
    {
        // For PostgreSQL
        if (config('database.default') === 'pgsql') {
            $results = DB::table('greenhouses')
                ->select(DB::raw("
                    CASE
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) < 1000 THEN 'کمتر از 1000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) BETWEEN 1000 AND 5000 THEN '1000-5000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) BETWEEN 5000 AND 10000 THEN '5000-10000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) > 10000 THEN 'بیشتر از 10000 متر'
                        ELSE 'نامشخص'
                    END as area_range,
                    COUNT(*) as count
                "))
                ->whereNotNull('meterage')
                ->where('meterage', '!=', '')
                ->whereRaw("meterage ~ '^[0-9]+$'")
                ->groupByRaw("
                    CASE
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) < 1000 THEN 'کمتر از 1000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) BETWEEN 1000 AND 5000 THEN '1000-5000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) BETWEEN 5000 AND 10000 THEN '5000-10000 متر'
                        WHEN meterage ~ '^[0-9]+$' AND CAST(meterage AS INTEGER) > 10000 THEN 'بیشتر از 10000 متر'
                        ELSE 'نامشخص'
                    END
                ")
                ->get();
        } else {
            // For MySQL
            $results = DB::table('greenhouses')
                ->select(DB::raw("
                    CASE
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) < 1000 THEN 'کمتر از 1000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) BETWEEN 1000 AND 5000 THEN '1000-5000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) BETWEEN 5000 AND 10000 THEN '5000-10000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) > 10000 THEN 'بیشتر از 10000 متر'
                        ELSE 'نامشخص'
                    END as area_range,
                    COUNT(*) as count
                "))
                ->whereNotNull('meterage')
                ->where('meterage', '!=', '')
                ->whereRaw("meterage REGEXP '^[0-9]+$'")
                ->groupByRaw("
                    CASE
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) < 1000 THEN 'کمتر از 1000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) BETWEEN 1000 AND 5000 THEN '1000-5000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) BETWEEN 5000 AND 10000 THEN '5000-10000 متر'
                        WHEN meterage REGEXP '^[0-9]+$' AND CAST(meterage AS UNSIGNED) > 10000 THEN 'بیشتر از 10000 متر'
                        ELSE 'نامشخص'
                    END
                ")
                ->get();
        }

        return $results->reject(function ($item) {
            return $item->area_range === 'نامشخص';
        })->map(function ($item) {
            return [
                'name' => $item->area_range,
                'count' => (int)$item->count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getGreenhousesByProduct()
    {
        return Greenhouse::select('product_type', DB::raw('COUNT(*) as count'))
            ->whereNotNull('product_type')
            ->where('product_type', '!=', '')
            ->groupBy('product_type')
            ->orderByDesc('count')
            ->get()
            ->map(function ($item) {
                return [
                    'name' => $item->product_type,
                    'count' => (int)$item->count, // Ensure integer
                    'color' => $this->generateRandomColor()
                ];
            })
            ->values(); // Reset array keys
    }

    private function getGreenhousesByClimateControl()
    {
        return [
            [
                'name' => 'دارای کنترل اقلیم',
                'count' => (int)Greenhouse::where('climate_system', true)->count(),
                'color' => '#10B981'
            ],
            [
                'name' => 'بدون کنترل اقلیم',
                'count' => (int)Greenhouse::where('climate_system', false)->count(),
                'color' => '#EF4444'
            ]
        ];
    }

    private function getGreenhousesByFeedingControl()
    {
        return [
            [
                'name' => 'دارای کنترل تغذیه',
                'count' => (int)Greenhouse::where('feeding_system', true)->count(),
                'color' => '#3B82F6'
            ],
            [
                'name' => 'بدون کنترل تغذیه',
                'count' => (int)Greenhouse::where('feeding_system', false)->count(),
                'color' => '#F59E0B'
            ]
        ];
    }

    private function getGreenhousesByCompanyClimate()
    {
        $results = DB::table('companies')
            ->join('automations', 'companies.id', '=', 'automations.climate_company_id')
            ->select('companies.name', DB::raw('COUNT(DISTINCT automations.greenhouse_id) as greenhouse_count'))
            ->where('companies.climate_system', true)
            ->whereNotNull('automations.climate_company_id')
            ->groupBy('companies.id', 'companies.name')
            ->havingRaw('COUNT(DISTINCT automations.greenhouse_id) > 0')
            ->orderByDesc('greenhouse_count')
            ->get();

        return $results->map(function ($company) {
            return [
                'name' => $company->name,
                'count' => (int)$company->greenhouse_count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getGreenhousesByCompanyFeeding()
    {
        $results = DB::table('companies')
            ->join('automations', 'companies.id', '=', 'automations.feeding_company_id')
            ->select('companies.name', DB::raw('COUNT(DISTINCT automations.greenhouse_id) as greenhouse_count'))
            ->where('companies.feeding_system', true)
            ->whereNotNull('automations.feeding_company_id')
            ->groupBy('companies.id', 'companies.name')
            ->havingRaw('COUNT(DISTINCT automations.greenhouse_id) > 0')
            ->orderByDesc('greenhouse_count')
            ->get();

        return $results->map(function ($company) {
            return [
                'name' => $company->name,
                'count' => (int)$company->greenhouse_count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getRegisteredVsLinkedGreenhouses()
    {
        $totalGreenhouses = Greenhouse::count();
        $linkedGreenhouses = DB::table('greenhouses')
            ->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('automations')
                    ->whereColumn('automations.greenhouse_id', 'greenhouses.id');
            })
            ->count();

        return [
            [
                'name' => 'گلخانه‌های ثبت‌نام‌شده',
                'count' => (int)$totalGreenhouses,
                'color' => '#8B5CF6'
            ],
            [
                'name' => 'گلخانه‌های متصل شده',
                'count' => (int)$linkedGreenhouses,
                'color' => '#06B6D4'
            ]
        ];
    }

    private function getGreenhouseAreaByProvince()
    {
        if (config('database.default') === 'pgsql') {
            $results = DB::table('greenhouses')
                ->join('provinces', 'greenhouses.province_id', '=', 'provinces.id')
                ->select('provinces.name as province_name')
                ->selectRaw("SUM(CASE WHEN meterage ~ '^[0-9]+$' THEN CAST(meterage AS INTEGER) ELSE 0 END) as total_area")
                ->whereNotNull('greenhouses.meterage')
                ->where('greenhouses.meterage', '!=', '')
                ->groupBy('provinces.id', 'provinces.name')
                ->havingRaw("SUM(CASE WHEN meterage ~ '^[0-9]+$' THEN CAST(meterage AS INTEGER) ELSE 0 END) > 0")
                ->orderByDesc('total_area')
                ->get();
        } else {
            $results = DB::table('greenhouses')
                ->join('provinces', 'greenhouses.province_id', '=', 'provinces.id')
                ->select('provinces.name as province_name')
                ->selectRaw("SUM(CASE WHEN meterage REGEXP '^[0-9]+$' THEN CAST(meterage AS UNSIGNED) ELSE 0 END) as total_area")
                ->whereNotNull('greenhouses.meterage')
                ->where('greenhouses.meterage', '!=', '')
                ->groupBy('provinces.id', 'provinces.name')
                ->havingRaw("SUM(CASE WHEN meterage REGEXP '^[0-9]+$' THEN CAST(meterage AS UNSIGNED) ELSE 0 END) > 0")
                ->orderByDesc('total_area')
                ->get();
        }

        return $results->map(function ($item) {
            return [
                'name' => $item->province_name,
                'count' => (int)round($item->total_area / 1000), // Convert to thousands and ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function getServerConnectedGreenhouses()
    {
        $results = DB::table('provinces')
            ->join('greenhouses', 'provinces.id', '=', 'greenhouses.province_id')
            ->join('automations', 'greenhouses.id', '=', 'automations.greenhouse_id')
            ->select('provinces.name', DB::raw('COUNT(DISTINCT greenhouses.id) as greenhouse_count'))
            ->where('automations.active', true)
            ->where(function ($query) {
                $query->whereNotNull('automations.climate_api_link')
                    ->orWhereNotNull('automations.feeding_api_link');
            })
            ->groupBy('provinces.id', 'provinces.name')
            ->havingRaw('COUNT(DISTINCT greenhouses.id) > 0')
            ->orderByDesc('greenhouse_count')
            ->get();

        return $results->map(function ($province) {
            return [
                'name' => $province->name,
                'count' => (int)$province->greenhouse_count, // Ensure integer
                'color' => $this->generateRandomColor()
            ];
        })->values(); // Reset array keys
    }

    private function generateRandomColor()
    {
        $colors = [
            '#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6',
            '#06B6D4', '#84CC16', '#F97316', '#EC4899', '#6366F1',
            '#14B8A6', '#F59E0B', '#EF4444', '#8B5CF6', '#06B6D4'
        ];

        return $colors[array_rand($colors)];
    }
}
