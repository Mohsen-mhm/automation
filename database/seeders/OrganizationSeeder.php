<?php

namespace Database\Seeders;

use App\Models\OrganizationUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item = [
            'fname' => 'default',
            'lname' => 'default',
            'national_id' => '2283273218',
            'organization_name' => 'default',
            'organization_level' => 'default',
            'national_card' => 'assets/img/default.png',
            'personnel_card' => 'assets/img/default.png',
            'introduction_letter' => 'assets/img/default.png',
            'province' => 'default',
            'city' => 'default',
            'address' => 'default',
            'postal' => '123456',
            'landline_number' => '07138475645',
            'phone_number' => '09175848714',
            'active' => 1,
            'status' => 'confirmed',
        ];

        OrganizationUser::query()->where([
            'national_id' => $item['national_id'],
        ])->firstOr(function () use ($item) {
            OrganizationUser::create($item);
            $user = User::create([
                'name' => $item['fname'] . ' ' . $item['lname'],
                'national_id' => $item['national_id'],
                'phone_number' => $item['phone_number'],
                'active' => 1,
            ]);

            $user->roles()->sync(Role::query()->whereName(Role::ORGANIZATION_ROLE)->first()->id);
        });
    }
}
