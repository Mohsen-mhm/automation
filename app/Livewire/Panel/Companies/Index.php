<?php

namespace App\Livewire\Panel\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(Company::COMPANY_INDEX), 403);
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.companies.index');
    }
}
