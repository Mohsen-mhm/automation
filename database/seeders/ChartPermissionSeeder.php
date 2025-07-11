<?php

namespace Database\Seeders;

use App\Models\ChartPermission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChartPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $charts = [
            // General Statistics
            [
                'chart_key' => 'users_count',
                'chart_name' => 'تعداد کاربران سامانه',
                'chart_category' => 'statistics',
                'admin_visible' => true,
                'company_visible' => false,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 1
            ],
            [
                'chart_key' => 'company_per_province',
                'chart_name' => 'شرکت‌ها بر حسب استان',
                'chart_category' => 'location',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 2
            ],
            [
                'chart_key' => 'greenhouse_per_province',
                'chart_name' => 'گلخانه‌ها بر حسب استان',
                'chart_category' => 'location',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => true,
                'organization_visible' => true,
                'sort_order' => 3
            ],
            [
                'chart_key' => 'climate_automation_per_company',
                'chart_name' => 'تعداد گلخانه‌های اقلیم اجرا شده توسط هر شرکت',
                'chart_category' => 'automation',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 4
            ],
            [
                'chart_key' => 'feeding_automation_per_company',
                'chart_name' => 'تعداد گلخانه‌های تغذیه اجرا شده توسط هر شرکت',
                'chart_category' => 'automation',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 5
            ],
            [
                'chart_key' => 'greenhouses_by_area',
                'chart_name' => 'گلخانه‌ها بر حسب متراژ',
                'chart_category' => 'greenhouse',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => true,
                'organization_visible' => false,
                'sort_order' => 6
            ],
            [
                'chart_key' => 'greenhouses_by_product',
                'chart_name' => 'گلخانه‌ها بر حسب محصول',
                'chart_category' => 'greenhouse',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => true,
                'organization_visible' => false,
                'sort_order' => 7
            ],
            [
                'chart_key' => 'greenhouses_by_climate_control',
                'chart_name' => 'گلخانه‌ها بر حسب کنترل اقلیم',
                'chart_category' => 'greenhouse',
                'admin_visible' => true,
                'company_visible' => false,
                'greenhouse_visible' => true,
                'organization_visible' => true,
                'sort_order' => 8
            ],
            [
                'chart_key' => 'greenhouses_by_feeding_control',
                'chart_name' => 'گلخانه‌ها بر حسب کنترل تغذیه',
                'chart_category' => 'greenhouse',
                'admin_visible' => true,
                'company_visible' => false,
                'greenhouse_visible' => true,
                'organization_visible' => true,
                'sort_order' => 9
            ],
            [
                'chart_key' => 'greenhouses_by_company_climate',
                'chart_name' => 'گلخانه‌ها بر حسب کنترل اقلیم شرکت‌ها',
                'chart_category' => 'company',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 10
            ],
            [
                'chart_key' => 'greenhouses_by_company_feeding',
                'chart_name' => 'گلخانه‌ها بر حسب کنترل تغذیه شرکت‌ها',
                'chart_category' => 'company',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 11
            ],
            [
                'chart_key' => 'registered_vs_linked_greenhouses',
                'chart_name' => 'تعداد گلخانه‌های موجود در استان و گلخانه‌های ثبت‌نام‌شده',
                'chart_category' => 'statistics',
                'admin_visible' => true,
                'company_visible' => false,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 12
            ],
            [
                'chart_key' => 'greenhouse_area_by_province',
                'chart_name' => 'متراژ گلخانه‌ها بر حسب استان',
                'chart_category' => 'location',
                'admin_visible' => true,
                'company_visible' => true,
                'greenhouse_visible' => true,
                'organization_visible' => true,
                'sort_order' => 13
            ],
            [
                'chart_key' => 'server_connected_greenhouses',
                'chart_name' => 'تعداد گلخانه‌های متصل به سرور در هر استان',
                'chart_category' => 'system',
                'admin_visible' => true,
                'company_visible' => false,
                'greenhouse_visible' => false,
                'organization_visible' => true,
                'sort_order' => 14
            ]
        ];

        foreach ($charts as $chart) {
            ChartPermission::updateOrCreate(
                ['chart_key' => $chart['chart_key']],
                $chart
            );
        }
    }
}
