<?php

namespace Database\Seeders;

use App\Models\Greenhouse;
use App\Models\GreenhouseAlert;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GreenHouseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item = [
            'name' => 'default',
            'substrate_type' => 'پرلیت',
            'product_type' => 'اسفناج',
            'licence_number' => '56168465',
            'meterage' => '3000',
            'operation_date' => now(),
            'construction_date' => now()->subMonths(5),
            'greenhouse_status' => 'فعال',
            'owner_name' => 'default',
            'owner_phone' => '09375074372',
            'owner_national_id' => '2285212917',
            'climate_system' => 1,
            'feeding_system' => 0,
            'province' => 'فارس',
            'city' => 'شیراز',
            'address' => 'شهرک آرین',
            'postal' => '7181111111',
            'location_link' => 'https://maps.app.goo.gl/vynZP2aEtoCvw1Cz6',
            'coordinates' => '29.725374, 52.460118',
            'latitude' => '29.725374',
            'longitude' => '52.460118',
            'operation_licence' => 'assets/img/default.png',
            'image' => 'assets/img/default.png',
            'active' => 1,
            'status' => 'confirmed',
        ];

        Greenhouse::query()->where([
            'owner_national_id' => $item['owner_national_id'],
        ])->firstOr(function () use ($item) {
            $greenhouse = Greenhouse::create($item);
            GreenhouseAlert::create(['greenhouse_id' => $greenhouse->id]);
            $user = User::create([
                'name' => $item['name'],
                'national_id' => $item['owner_national_id'],
                'phone_number' => $item['owner_phone'],
                'active' => 1,
            ]);

            $user->roles()->sync(Role::query()->whereName(Role::GREENHOUSE_ROLE)->first()->id);
        });
    }
}
