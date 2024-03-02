<?php

namespace App\Livewire\Panel\Organizations;

use App\Models\OrganizationUser;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowOrganization extends Component
{
    public $organization;

    public $nationalCard;
    public $personnelCard;
    public $introductionLetter;

    protected $listeners = [
        'showInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->organization = collect(OrganizationUser::query()->find($id));
        $this->nationalCard = $this->organization->get('national_card');
        $this->personnelCard = $this->organization->get('personnel_card');
        $this->introductionLetter = $this->organization->get('introduction_letter');
    }

    public function mount(): void
    {
        abort_if(!Gate::allows(OrganizationUser::ORGAN_INDEX), 403);
    }

    public function render()
    {
        return view('livewire.panel.organizations.show-organization');
    }
}
