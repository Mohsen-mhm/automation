<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Config;
use App\Models\Greenhouse;
use App\Models\Company;
use Illuminate\Support\Collection;

class Map extends Component
{
    public array $substrates = [];
    public array $productTypes = [];
    public array $provinces = [];
    public array $companyProvinces = [];
    public array $companyType = [];
    public array $substrateFilter = [];
    public array $productFilter = [];
    public array $provinceFilter = [];
    public array $companyProvinceFilter = [];
    public array $companyTypeFilter = [];

    public string $greenhousesData;
    public string $companiesData;
    public array $greenhouseFilterNames = ['substrateFilter', 'productFilter', 'provinceFilter'];
    public array $companyFilterNames = ['companyProvinceFilter', 'companyTypeFilter'];

    public function mount(): void
    {
        collect(json_decode(collect(Config::query()->whereName(Config::SUBSTRATE)->first())->get('value')))
            ->each(function ($item) {
                $this->substrates[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->substrateFilter[] = $item;
            });
        collect(json_decode(collect(Config::query()->whereName(Config::PRODUCT_TYPE)->first())->get('value')))
            ->each(function ($item) {
                $this->productTypes[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->productFilter[] = $item;
            });
        collect(Greenhouse::query()->pluck('province'))->unique()
            ->each(function ($item) {
                $this->provinces[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->provinceFilter[] = $item;
            });
        collect(Company::query()->pluck('province'))->unique()
            ->each(function ($item) {
                $this->companyProvinces[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->companyProvinceFilter[] = $item;
            });
        collect(json_decode(collect(Config::query()->whereName(Config::COMPANY_TYPE)->first())->get('value')))
            ->each(function ($item) {
                $this->companyType[] = [
                    'uuid' => Str::uuid()->toString(),
                    'name' => $item
                ];
                $this->companyTypeFilter[] = $item;
            });

        $this->assignFilteredData();
    }

    public function updated($property): void
    {
        $this->assignFilteredData();
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
            if ($greenhouse->active
                && in_array($greenhouse->substrate_type, $this->substrateFilter)
                && in_array($greenhouse->product_type, $this->productFilter)
                && in_array($greenhouse->province, $this->provinceFilter)) {
                return $greenhouse;
            }
            return null;
        });
    }


    public function filterCompany(): Collection
    {
        return collect(Company::all())->filter(function ($company) {
            if ($company->active
                && in_array($company->type, $this->companyTypeFilter)
                && in_array($company->province, $this->companyProvinceFilter)) {
                return $company;
            }
            return null;
        });
    }

    public function assignFilteredData(): void
    {
        $filteredGreenhouses = $this->filterGreenhouse();

        $greenhouseData = [];
        foreach ($filteredGreenhouses as $greenhouse) {
            $greenhouseData[] = [
                'coordinates' => [$greenhouse->latitude, $greenhouse->longitude],
                'image' => asset('storage/' . $greenhouse->image),
                'name' => $greenhouse->name,
                'area' => $greenhouse->province . ' - ' . $greenhouse->city,
                'product' => $greenhouse->product_type . ' - ' . $greenhouse->substrate_type,
                'space' => $greenhouse->meterage,
                'outsideTemp' => '-',
                'outsideHumidity' => '-',
                'lightIntensity' => '-',
                'windSpeed' => '-',
                'insideTemp' => '-',
                'insideHumidity' => '-',
                'company' => false
            ];
        }
        $this->greenhousesData = json_encode($greenhouseData);

        $filteredCompany = $this->filterCompany();
        $companiesData = [];
        foreach ($filteredCompany as $company) {
            $companiesData[] = [
                'coordinates' => [$company->latitude, $company->longitude],
                'image' => asset('storage/' . $company->company_logo),
                'name' => $company->name . "\n" . $company->type,
                'area' => $company->province . "\n" . $company->city . "\n" . $company->address,
                'company' => true
            ];
        }
        $this->companiesData = json_encode($companiesData);
    }

    public function render()
    {
        return view('livewire.map');
    }
}

