<?php

namespace App\Livewire\Panel\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowCompany extends Component
{
    public $company;
    public $companyLogo = null;
    public $brandLogo = null;
    public $trademarkCertificate = null;
    public $operationLicence = null;

    protected $listeners = [
        'showInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->company = collect(Company::query()->find($id));
        $this->companyLogo = $this->company->get('company_logo');
        $this->brandLogo = $this->company->get('brand_logo');
        $this->trademarkCertificate = $this->company->get('trademark_certificate');
        $this->operationLicence = $this->company->get('operation_licence');
    }

    public function mount(): void
    {
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);
    }

    public function render()
    {
        return view('livewire.panel.companies.show-company');
    }
}
