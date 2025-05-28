<?php

namespace App\Livewire\Panel\Alerts;

use App\Models\Role;
use Livewire\Attributes\Layout;
use Livewire\Component;

class IndexAdmin extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.alerts.index-admin');
    }
}
