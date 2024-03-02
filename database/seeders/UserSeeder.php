<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = [
            'name' => 'ادمین سیمرغ',
            'national_id' => '1234567891',
            'phone_number' => '09375074371',
            'active' => true,
        ];

        User::query()->whereNationalId($admin['national_id'])
            ->firstOr(function () use ($admin) {
                $user = User::create($admin);
                $user->roles()->sync(Role::query()->whereName(Role::ADMIN_ROLE)->first()->id);
            });
    }
}
