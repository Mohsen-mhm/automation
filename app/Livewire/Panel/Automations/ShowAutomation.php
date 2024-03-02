<?php

namespace App\Livewire\Panel\Automations;

use App\Models\Automation;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowAutomation extends Component
{
    public $automation;

    protected $listeners = [
        'showInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->automation = Automation::query()->find($id);
    }

    public function mount(): void
    {
        abort_if(!Gate::allows(Automation::AUTOMATION_INDEX), 403);
    }

    public function render()
    {
        return view('livewire.panel.automations.show-automation');
    }
}
