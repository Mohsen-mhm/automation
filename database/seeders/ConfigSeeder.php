<?php

namespace Database\Seeders;

use App\Models\Config;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'name' => 'substrate-type',
                'title' => 'نوع بستر کشت',
                'type' => Config::JSON_TYPE,
                'value' => json_encode([
                    'پرلیت',
                    'پیت ماس',
                    'هوموس',
                    'کمپوست',
                    'ورمی کمپوست',
                    'کوکوپیت',
                    'ورمیکولیت',
                ]),
            ],
            [
                'name' => 'product-type',
                'title' => 'نوع محصول',
                'type' => Config::JSON_TYPE,
                'value' => json_encode([
                    'قارچ',
                    'توت فرنگی',
                    'آلوئه ورا',
                    'زعفران',
                    'اسفناج',
                    'کدو و برگ',
                    'فلفل سبز',
                    'خیار',
                    'گوجه فرنگی',
                    'به لیمو',
                    'انگور',
                ]),
            ],
            [
                'name' => 'company-type',
                'title' => 'نوع شرکت',
                'type' => Config::JSON_TYPE,
                'value' => json_encode([
                    'سهامی',
                    'مسئولیت محدود',
                    'تضامنی',
                    'مختلط غیر سهامی',
                    'مختلط سهامی',
                    'نسبی',
                    'تعاونی تولید و مصرف',
                ]),
            ],
            [
                'name' => 'greenhouse-type',
                'title' => 'نوع گلخانه',
                'type' => Config::JSON_TYPE,
                'value' => json_encode([
                    'به هم پيوسته',
                    'دوقلو',
                    'خانگی',
                    'تونلی',
                    'تحقيقاتی',
                    'تجاری',
                ]),
            ],
            [
                'name' => 'greenhouse-status',
                'title' => 'وضعیت گلخانه',
                'type' => Config::JSON_TYPE,
                'value' => json_encode([
                    'فعال',
                    'غیرفعال',
                    'در دست احداث',
                    'بهره برداری شده',
                ]),
            ],
            [
                'name' => 'company-tariff',
                'title' => 'تعرفه شرکت ها',
                'type' => Config::STRING_TYPE,
                'value' => '5000000',
            ],
            [
                'name' => 'greenhouse-tariff',
                'title' => 'تعرفه گلخانه ها',
                'type' => Config::STRING_TYPE,
                'value' => '1000000',
            ],
        ];

        foreach ($items as $item) {
            $config = Config::query()->whereName($item['name'])->first();

            if (!$config) {
                Config::create($item);
            }
        }
    }
}
