<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'user-index',
                'title' => 'دسترسی به صفحه کاربران',
            ],
            [
                'name' => 'user-edit',
                'title' => 'ویرایش کاربر',
            ],
            [
                'name' => 'role-index',
                'title' => 'دسترسی به صفحه نقش ها',
            ],
            [
                'name' => 'role-assign',
                'title' => 'اختصاص نقش به کاربر',
            ],
            [
                'name' => 'permission-index',
                'title' => 'دسترسی به صفحه دسترسی ها',
            ],
            [
                'name' => 'permission-assign',
                'title' => 'اختصاص دسترسی به نقش',
            ],
            [
                'name' => 'config-index',
                'title' => 'دسترسی به صفحه تنظیمات',
            ],
            [
                'name' => 'config-edit',
                'title' => 'ویرایش تنظیمات',
            ],
            [
                'name' => 'company-index',
                'title' => 'دسترسی به لیست شرکت ها',
            ],
            [
                'name' => 'company-create',
                'title' => 'ایجاد شرکت جدید',
            ],
            [
                'name' => 'company-edit',
                'title' => 'ویرایش شرکت',
            ],
            [
                'name' => 'company-delete',
                'title' => 'حدف شرکت',
            ],
            [
                'name' => 'company-confirm',
                'title' => 'تایید/رد کردن اطلاعات شرکت',
            ],
            [
                'name' => 'organ-index',
                'title' => 'دسترسی به لیست کاربران سازمانی',
            ],
            [
                'name' => 'organ-create',
                'title' => 'ایجاد کاربر سازمانی جدید',
            ],
            [
                'name' => 'organ-edit',
                'title' => 'ویرایش کاربر سازمانی',
            ],
            [
                'name' => 'organ-delete',
                'title' => 'حدف کاربر سازمانی',
            ],
            [
                'name' => 'organ-confirm',
                'title' => 'تایید/رد کردن اطلاعات کاربر سازمانی',
            ],
            [
                'name' => 'greenhouse-index',
                'title' => 'دسترسی به لیست گلخانه ها',
            ],
            [
                'name' => 'greenhouse-create',
                'title' => 'ایجاد گلخانه جدید',
            ],
            [
                'name' => 'greenhouse-edit',
                'title' => 'ویرایش گلخانه',
            ],
            [
                'name' => 'greenhouse-delete',
                'title' => 'حدف گلخانه',
            ],
            [
                'name' => 'greenhouse-confirm',
                'title' => 'تایید/رد کردن اطلاعات گلخانه',
            ],
            [
                'name' => 'automation-index',
                'title' => 'دسترسی به لیست اتوماسیون ها',
            ],
            [
                'name' => 'automation-create',
                'title' => 'ایجاد اتوماسیون جدید',
            ],
            [
                'name' => 'automation-edit',
                'title' => 'ویرایش اتوماسیون',
            ],
            [
                'name' => 'automation-delete',
                'title' => 'حدف اتوماسیون',
            ],
            [
                'name' => 'automation-confirm',
                'title' => 'تایید/رد کردن اطلاعات اتوماسیون',
            ],
            [
                'name' => 'release-chart',
                'title' => 'انتشار نمودار ها',
            ],
            [
                'name' => 'profile-index',
                'title' => 'دسترسی به صفحه پروفایل',
            ],
            [
                'name' => 'profile-edit',
                'title' => 'ویرایش اطلاعات پروفایل',
            ],
            [
                'name' => 'alert-index',
                'title' => 'دسترسی به صفحه محدوده ها',
            ],
            [
                'name' => 'filter-active',
                'title' => 'فعال/غیرفعال کردن فیلترها',
            ],
            [
                'name' => 'about-us-index',
                'title' => 'دسترسی به صفحه درباره ما',
            ],
            [
                'name' => 'about-us-edit',
                'title' => 'ویرایش صفحه درباره ما',
            ],
            [
                'name' => 'contact-us-index',
                'title' => 'دسترسی به صفحه تماس با ما',
            ],
            [
                'name' => 'city-index',
                'title' => 'دسترسی به لیست شهر ها',
            ],
            [
                'name' => 'city-create',
                'title' => 'ایجاد شهر جدید',
            ],
            [
                'name' => 'city-edit',
                'title' => 'ویرایش شهر',
            ],
            [
                'name' => 'city-delete',
                'title' => 'حدف شهر',
            ],
            [
                'name' => 'province-index',
                'title' => 'دسترسی به لیست استان ها',
            ],
            [
                'name' => 'province-create',
                'title' => 'ایجاد استان جدید',
            ],
            [
                'name' => 'province-edit',
                'title' => 'ویرایش استان',
            ],
            [
                'name' => 'province-delete',
                'title' => 'حدف استان',
            ],
            [
                'name' => 'chart-view',
                'title' => 'مشاهده نمودارها',
            ],
            [
                'name' => 'chart-manage-permissions',
                'title' => 'مدیریت دسترسی نمودارها',
            ],
        ];

        foreach ($items as $item) {
            $permission = Permission::query()->whereName($item['name'])->first();

            if (!$permission) {
                Permission::create($item);
            }
        }
    }
}
