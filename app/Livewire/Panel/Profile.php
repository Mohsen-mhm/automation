<?php

namespace App\Livewire\Panel;

use App\Models\Company;
use App\Models\Greenhouse;
use App\Models\OrganizationUser;
use App\Models\Role;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Profile extends Component
{
    public Collection $data;

    public function mount()
    {
        if (auth()->user()->hasRole(Role::COMPANY_ROLE)) {
            $this->data = collect(Company::query()->whereNationalId(auth()->user()->national_id)->first());
        } elseif (auth()->user()->hasRole(Role::GREENHOUSE_ROLE)) {
            $this->data = collect(Greenhouse::query()->whereOwnerNationalId(auth()->user()->national_id)->first());
        } elseif (auth()->user()->hasRole(Role::ORGANIZATION_ROLE)) {
            $this->data = collect(OrganizationUser::query()->whereNationalId(auth()->user()->national_id)->first());
        } else {
            abort(403);
        }
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.profile');
    }
}
