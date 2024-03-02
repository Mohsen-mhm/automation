<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $item = [
            'name' => 'default',
            'type' => 'سهامی',
            'national_id' => '64846846854',
            'registration_number' => '123456',
            'registration_place' => 'شیراز',
            'registration_date' => now(),
            'climate_system' => 1,
            'feeding_system' => 1,
            'ceo_name' => 'default',
            'ceo_phone' => '09175848714',
            'ceo_national_id' => '2285212917',
            'interface_name' => 'default',
            'interface_phone' => '09212357058',
            'company_logo' => 'assets/img/default.png',
            'brand' => 'default',
            'brand_logo' => 'assets/img/default.png',
            'trademark_certificate' => 'assets/img/default.png',
            'province' => 'فارس',
            'city' => 'شیراز',
            'address' => 'شهرک آرین',
            'postal' => '7181111111',
            'landline_number' => '07123456789',
            'phone_number' => '09175848714',
            'location_link' => 'https://maps.app.goo.gl/vynZP2aEtoCvw1Cz6',
            'coordinates' => '29.725374, 52.460118',
            'latitude' => '29.725374',
            'longitude' => '52.460118',
            'website' => 'www.default.ir',
            'email' => 'info@default.ir',
            'official_newspaper' => 'assets/img/default.png',
            'operation_licence' => 'assets/img/default.png',
            'active' => 1,
            'status' => 'confirmed',
        ];

        Company::query()->where([
            'national_id' => $item['national_id'],
        ])->firstOr(function () use ($item) {
            Company::create($item);
            $user = User::create([
                'name' => $item['name'],
                'national_id' => $item['national_id'],
                'phone_number' => $item['interface_phone'],
                'active' => 1,
            ]);

            $user->roles()->sync(Role::query()->whereName(Role::COMPANY_ROLE)->first()->id);
        });
    }
}
