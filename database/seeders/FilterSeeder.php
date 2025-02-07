<?php

namespace Database\Seeders;

use App\Models\Filter;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FilterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filters = [
            [
                'uuid' => Str::uuid(),
                'name' => Filter::GREENHOUSE_SUBSTRATE_FILTER,
                'title' => 'بستر',
                'type' => Filter::GREENHOUSE_TYPE,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => Filter::GREENHOUSE_PRODUCT_FILTER,
                'title' => 'محصول',
                'type' => Filter::GREENHOUSE_TYPE,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => Filter::GREENHOUSE_PROVINCE_FILTER,
                'title' => 'استان',
                'type' => Filter::GREENHOUSE_TYPE,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => Filter::COMPANY_TYPE_FILTER,
                'title' => 'نوع',
                'type' => Filter::COMPANY_TYPE,
            ],
            [
                'uuid' => Str::uuid(),
                'name' => Filter::COMPANY_PROVINCE_FILTER,
                'title' => 'استان',
                'type' => Filter::COMPANY_TYPE,
            ],
        ];

        foreach ($filters as $filter) {
            Filter::query()->updateOrCreate(['name' => $filter['name']], $filter);
        }
    }
}
