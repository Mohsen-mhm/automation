<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\Company;
use App\Models\Automation;
use Illuminate\Support\Collection;

class Map extends Component
{
    public string $activeTab = 'greenhouse';
    public array $substrates = [];
    public array $productTypes = [];
    public array $provinces = [];
    public array $automationTypes = [];
    public array $serverConnections = [];
    public array $companyProvinces = [];
    public array $companyType = [];
    public array $companyAutomation = [];
    public array $substrateFilter = [];
    public array $productFilter = [];
    public array $provinceFilter = [];
    public array $automationTypeFilter = [];
    public array $serverConnectionFilter = [];
    public array $companyProvinceFilter = [];
    public array $companyTypeFilter = [];
    public array $companyAutomationFilter = [];

    public string $greenhousesData;
    public string $companiesData;
    public array $greenhouseFilterNames = ['substrateFilter', 'productFilter', 'provinceFilter', 'automationTypeFilter', 'serverConnectionFilter'];
    public array $companyFilterNames = ['companyProvinceFilter', 'companyTypeFilter', 'companyAutomationFilter'];

    public function mount(): void
    {
        $this->prepareGreenhouseFilterData();
        $this->prepareCompanyFilterData();

        // Dispatch initial data to JavaScript
        $this->dispatch('submit-filter', ['type' => 'greenhouse', 'data' => $this->greenhousesData]);
    }

    public function changeTab($tab): void
    {
        $this->activeTab = $tab;

        // Dispatch the correct data based on active tab
        if ($tab === 'greenhouse') {
            $this->dispatch('submit-filter', ['type' => 'greenhouse', 'data' => $this->greenhousesData]);
        } else if ($tab === 'company') {
            $this->dispatch('submit-filter', ['type' => 'company', 'data' => $this->companiesData]);
        }

        // Also dispatch tab change event for any additional JavaScript handling
        $this->dispatch('tab-changed', ['activeTab' => $tab]);
    }

    public function prepareGreenhouseFilterData(): void
    {
        // Reset arrays first
        $this->substrates = [];
        $this->productTypes = [];
        $this->provinces = [];
        $this->automationTypes = [];
        $this->serverConnections = [];
        $this->substrateFilter = [];
        $this->productFilter = [];
        $this->provinceFilter = [];
        $this->automationTypeFilter = [];
        $this->serverConnectionFilter = [];

        collect(Greenhouse::query()->where('active', true)->pluck('substrate_type'))->unique()
            ->each(function ($item) {
                $this->substrates[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->substrateFilter[] = $item;
            });

        collect(Greenhouse::query()->where('active', true)->pluck('product_type'))->unique()
            ->each(function ($item) {
                $this->productTypes[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->productFilter[] = $item;
            });

        collect(
            Greenhouse::with('province')
                ->where('active', true)
                ->get()
                ->pluck('province.name')
                ->filter()
                ->unique()
        )->each(function ($item) {
            $this->provinces[] = [
                'uuid' => Str::uuid()->toString(),
                'name' => $item
            ];
            $this->provinceFilter[] = $item;
        });

        // Prepare automation type filter (climate_system + feeding_system combined)
        $this->automationTypes = [
            ['uuid' => Str::uuid()->toString(), 'name' => 'دارای اتوماسیون کنترل اقلیم', 'value' => 'climate'],
            ['uuid' => Str::uuid()->toString(), 'name' => 'دارای اتوماسیون تغذیه', 'value' => 'feeding']
        ];
        $this->automationTypeFilter = ['climate', 'feeding']; // Include both by default

        // Prepare server connection filter (has automation record)
        $this->serverConnections = [
            ['uuid' => Str::uuid()->toString(), 'name' => 'دارای اتصال به سرور', 'value' => true],
            ['uuid' => Str::uuid()->toString(), 'name' => 'فاقد اتصال به سرور', 'value' => false]
        ];
        $this->serverConnectionFilter = [true, false]; // Include both by default

        $this->assignGreenhouseFilteredData();
    }

    public function prepareCompanyFilterData(): void
    {
        // Reset arrays first
        $this->companyProvinces = [];
        $this->companyType = [];
        $this->companyAutomation = [];
        $this->companyProvinceFilter = [];
        $this->companyTypeFilter = [];
        $this->companyAutomationFilter = [];

        collect(
            Company::with('province')
                ->where('active', true)
                ->get()
                ->pluck('province.name')
                ->filter()
                ->unique()
        )->each(function ($item) {
            $this->companyProvinces[] = [
                'uuid' => Str::uuid()->toString(),
                'name' => $item
            ];
            $this->companyProvinceFilter[] = $item;
        });

        collect(Company::query()->where('active', true)->pluck('type'))->unique()
            ->each(function ($item) {
                $this->companyType[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->companyTypeFilter[] = $item;
            });

        // Prepare company automation filter
        $this->companyAutomation = [
            ['uuid' => Str::uuid()->toString(), 'name' => 'مجری اتوماسیون کنترل اقلیم', 'value' => 'climate'],
            ['uuid' => Str::uuid()->toString(), 'name' => 'مجری اتوماسیون تغذیه', 'value' => 'feeding']
        ];
        $this->companyAutomationFilter = ['climate', 'feeding']; // Include both by default

        $this->assignCompanyFilteredData();
    }

    public function updated($property): void
    {
        $this->assignCompanyFilteredData();
        $this->assignGreenhouseFilteredData();
        $field = explode('.', $property);
        if (in_array($field[0], $this->greenhouseFilterNames)) {
            $this->dispatch('submit-filter', ['type' => 'greenhouse', 'data' => $this->greenhousesData]);
        } elseif (in_array($field[0], $this->companyFilterNames)) {
            $this->dispatch('submit-filter', ['type' => 'company', 'data' => $this->companiesData]);
        }
    }

    public function filterGreenhouse(): Collection
    {
        return collect(Greenhouse::all())->filter(function ($greenhouse) {
            // Basic filters
            if (!$greenhouse->active
                || !in_array($greenhouse->substrate_type, $this->substrateFilter)
                || !in_array($greenhouse->product_type, $this->productFilter)
                || !in_array($greenhouse->province->name, $this->provinceFilter)) {
                return false;
            }

            // Automation type filter
            $automationTypeMatch = false;
            if (empty($this->automationTypeFilter)) {
                return false;
            }

            foreach ($this->automationTypeFilter as $filterType) {
                if ($filterType === 'climate' && $greenhouse->climate_system) {
                    $automationTypeMatch = true;
                    break;
                }
                if ($filterType === 'feeding' && $greenhouse->feeding_system) {
                    $automationTypeMatch = true;
                    break;
                }
            }

            if (!$automationTypeMatch) {
                return false;
            }

            // Server connection filter (check if automation record exists)
            if (empty($this->serverConnectionFilter)) {
                return false;
            }

            $hasAutomationRecord = Automation::where('greenhouse_id', $greenhouse->id)->exists();
            $serverConnectionMatch = false;

            foreach ($this->serverConnectionFilter as $filterValue) {
                $boolFilterValue = $filterValue === true || $filterValue === 1 || $filterValue === '1' || $filterValue === 'true';

                if (($boolFilterValue && $hasAutomationRecord) || (!$boolFilterValue && !$hasAutomationRecord)) {
                    $serverConnectionMatch = true;
                    break;
                }
            }

            return $serverConnectionMatch;
        });
    }

    public function filterCompany(): Collection
    {
        return collect(Company::all())->filter(function ($company) {
            // Basic filters
            if (!$company->active
                || !in_array($company->type, $this->companyTypeFilter)
                || !in_array($company->province->name, $this->companyProvinceFilter)) {
                return false;
            }

            // Company automation filter
            if (empty($this->companyAutomationFilter)) {
                return false;
            }

            $automationMatch = false;
            foreach ($this->companyAutomationFilter as $filterType) {
                if ($filterType === 'climate' && $company->climate_system) {
                    $automationMatch = true;
                    break;
                }
                if ($filterType === 'feeding' && $company->feeding_system) {
                    $automationMatch = true;
                    break;
                }
            }

            return $automationMatch;
        });
    }

    public function assignCompanyFilteredData(): void
    {
        $filteredCompany = $this->filterCompany();
        $companiesData = [];
        foreach ($filteredCompany as $company) {
            $companiesData[] = [
                'coordinates' => [$company->latitude, $company->longitude],
                'image' => asset($company->company_logo),
                'name' => $company->name,
                'website' => $company->website,
                'tel' => $company->landline_number,
                'brand_logo' => asset($company->brand_logo),
                'brand' => $company->brand,
                'area' => $company->province->name . "\n" . $company->city->name . "\n" . $company->address,
                'climateSystem' => $company->climate_system ? 'مجری اتوماسیون کنترل اقلیم' : 'فاقد اتوماسیون کنترل اقلیم',
                'feedingSystem' => $company->feeding_system ? 'مجری اتوماسیون تغذیه' : 'فاقد اتوماسیون تغذیه',
                'company' => true
            ];
        }
        $this->companiesData = json_encode($companiesData);
    }

    public function assignGreenhouseFilteredData(): void
    {
        $filteredGreenhouses = $this->filterGreenhouse();

        $greenhouseData = [];
        foreach ($filteredGreenhouses as $greenhouse) {
            $data = [
                'Reg_1' => '-',
                'Reg_2' => '-',
                'Reg_3' => '-',
                'Reg_4' => '-',
                'Reg_5' => '-',
                'Reg_6' => '-'
            ];
            $climateAutomation = "فاقد اتوماسیون اقلیم فعال";
            $feedingAutomation = "فاقد اتوماسیون تغذیه فعال";
            if ($greenhouse->automation->count()) {
                $automation = $greenhouse->automation->first();
                if ($automation && $automation->active) {
                    if ($automation->climate_api_link) {
                        try {
                            $res = Http::get($automation->climate_api_link)->collect();

                            $data = $res->only(['Reg_1', 'Reg_2', 'Reg_3', 'Reg_4', 'Reg_5', 'Reg_6'])->map(function ($item) {
                                if ($item && is_int($item)) {
                                    return $item / 10;
                                }
                                return $item;
                            })->toArray();
                        } catch (\Exception $exception) {
                            Log::error($exception->getMessage());
                        }
                    }
                    if ($automation->climate_company_id) {
                        $climateAutomation = str_contains('شرکت', $automation->climateCompany->name) ? $automation->climateCompany->name : "شرکت " . $automation->climateCompany->name;
                    }
                    if ($automation->feeding_company_id) {
                        $feedingAutomation = str_contains('شرکت', $automation->feedingCompany->name) ? $automation->feedingCompany->name : "شرکت " . $automation->feedingCompany->name;
                    }
                }
            }

            $hasAutomationRecord = Automation::where('greenhouse_id', $greenhouse->id)->exists();

            $greenhouseData[] = [
                'coordinates' => [$greenhouse->latitude, $greenhouse->longitude],
                'image' => asset($greenhouse->image),
                'name' => $greenhouse->name,
                'area' => $greenhouse->province->name . ' - ' . $greenhouse->city->name,
                'product' => $greenhouse->product_type . ' - ' . $greenhouse->substrate_type,
                'space' => $greenhouse->meterage,
                'climateAutomation' => $climateAutomation,
                'feedingAutomation' => $feedingAutomation,
                'climateSystem' => $greenhouse->climate_system ? 'دارای اتوماسیون کنترل اقلیم' : 'فاقد اتوماسیون کنترل اقلیم',
                'feedingSystem' => $greenhouse->feeding_system ? 'دارای اتوماسیون تغذیه' : 'فاقد اتوماسیون تغذیه',
                'serverConnection' => $hasAutomationRecord ? 'دارای اتصال به سرور' : 'فاقد اتصال به سرور',
                'outsideTemp' => array_key_exists('Reg_1', $data) ? $data['Reg_1'] : '-',
                'outsideHumidity' => array_key_exists('Reg_2', $data) ? $data['Reg_2'] : '-',
                'lightIntensity' => array_key_exists('Reg_3', $data) ? $data['Reg_3'] : '-',
                'windSpeed' => array_key_exists('Reg_4', $data) ? $data['Reg_4'] : '-',
                'insideTemp' => array_key_exists('Reg_5', $data) ? $data['Reg_5'] : '-',
                'insideHumidity' => array_key_exists('Reg_6', $data) ? $data['Reg_6'] : '-',
                'company' => false
            ];
        }
        $this->greenhousesData = json_encode($greenhouseData);
    }

    public function resetFilters(): void
    {
        if ($this->activeTab == 'greenhouse') {
            $this->prepareGreenhouseFilterData();
            $this->dispatch('submit-filter', ['type' => 'greenhouse', 'data' => $this->greenhousesData]);
        } else {
            $this->prepareCompanyFilterData();
            $this->dispatch('submit-filter', ['type' => 'company', 'data' => $this->companiesData]);
        }
    }

    public function render()
    {
        return view('livewire.map');
    }
}
