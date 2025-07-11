<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\Province;
use App\Models\User;
use Illuminate\Console\Command;

class SetDefaultLocation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:set-default-location';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $province = Province::where('slug', 'fars')->first();
        $city = City::where('slug', 'shyraz')->first();

        $greenhouses = Greenhouse::all();
        foreach ($greenhouses as $greenhouse) {
            $greenhouse->update(['province_id' => $province->id, 'city_id' => $city->id]);
        }
        $this->info(count($greenhouses) . " greenhouses synced successfully!");
        usleep(500000);

        $companies = Company::all();
        foreach ($companies as $company) {
            $company->update(['province_id' => $province->id, 'city_id' => $city->id]);
        }
        $this->info(count($companies) . " companies synced successfully!");
    }
}
