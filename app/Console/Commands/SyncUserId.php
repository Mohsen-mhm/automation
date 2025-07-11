<?php

namespace App\Console\Commands;

use App\Models\City;
use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\User;
use Illuminate\Console\Command;

class SyncUserId extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:user-id';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync user id on company, greenhouse and organization';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $greenhouses = Greenhouse::all();
        foreach ($greenhouses as $greenhouse) {
            $user = User::query()->where([
                'national_id' => $greenhouse->owner_national_id,
                'phone_number' => $greenhouse->owner_phone,
            ])->first();
            if ($user) {
                $greenhouse->update(['user_id' => $user->id]);
            }
        }
        $this->info(count($greenhouses) . " greenhouses synced successfully!");
        usleep(500000);

        $companies = Company::all();
        foreach ($companies as $company) {
            $user = User::query()->where([
                'national_id' => $company->national_id,
                'phone_number' => $company->interface_phone,
            ])->first();
            if ($user) {
                $company->update(['user_id' => $user->id]);
            }
        }
        $this->info(count($companies) . " companies synced successfully!");
        usleep(500000);

        $organizations = OrganizationUser::all();
        foreach ($organizations as $organization) {
            $user = User::query()->where([
                'national_id' => $organization->national_id,
                'phone_number' => $organization->phone_number,
            ])->first();
            if ($user) {
                $organization->update(['user_id' => $user->id]);
            }
        }
        $this->info(count($organizations) . " organizations synced successfully!");
    }
}
