<?php

namespace App\Livewire\Panel\Alerts;

use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!auth()->user()->hasRole(Role::GREENHOUSE_ROLE), 403);
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.alerts.index');
    }
}
