<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'ADMIN',
                'title' => 'ادمین',
            ],
            [
                'name' => 'ORGANIZATION',
                'title' => 'سازمان جهاد',
            ],
            [
                'name' => 'COMPANY',
                'title' => 'شرکت اتوماسیون',
            ],
            [
                'name' => 'GREENHOUSE',
                'title' => 'گلخانه دار',
            ],
        ];

        foreach ($items as $item) {
            $role = Role::query()->whereName($item['name'])->first();

            if (!$role) {
                Role::create($item);
            }
        }

        $adminRole = Role::query()->whereName(Role::ADMIN_ROLE)->first();
        $adminPermissions = Permission::query()
            ->whereNot('name', 'profile-index')->whereNot('name', 'profile-edit')
            ->whereNot('name', 'alert-index')
            ->get();
        $adminRole->permissions()->sync($adminPermissions->pluck('id'));

        $organRole = Role::query()->whereName(Role::ORGANIZATION_ROLE)->first();
        $organPermissions = Permission::query()
            ->where('name', 'profile-index')->orWhere('name', 'profile-edit')
            ->orWhere('name', 'company-index')->orWhere('name', 'company-create')->orWhere('name', 'company-edit')->orWhere('name', 'company-confirm')
            ->orWhere('name', 'greenhouse-index')->orWhere('name', 'greenhouse-create')->orWhere('name', 'greenhouse-edit')->orWhere('name', 'greenhouse-confirm')
            ->orWhere('name', 'automation-index')->orWhere('name', 'automation-create')->orWhere('name', 'automation-edit')->orWhere('name', 'automation-confirm')
            ->get();
        $organRole->permissions()->sync($organPermissions->pluck('id'));

        $companyRole = Role::query()->whereName(Role::COMPANY_ROLE)->first();
        $companyPermissions = Permission::query()
            ->where('name', 'profile-index')->orWhere('name', 'profile-edit')
            ->orWhere('name', 'greenhouse-index')
            ->orWhere('name', 'automation-index')->orWhere('name', 'automation-create')->orWhere('name', 'automation-edit')->orWhere('name', 'automation-confirm')
            ->get();
        $companyRole->permissions()->sync($companyPermissions->pluck('id'));

        $greenhouseRole = Role::query()->whereName(Role::GREENHOUSE_ROLE)->first();
        $greenhousePermissions = Permission::query()
            ->where('name', 'profile-index')->orWhere('name', 'profile-edit')->orWhere('name', 'alert-index')
            ->orWhere('name', 'automation-index')->orWhere('name', 'automation-create')->orWhere('name', 'automation-edit')->orWhere('name', 'automation-confirm')
            ->get();
        $greenhouseRole->permissions()->sync($greenhousePermissions->pluck('id'));
    }
}
