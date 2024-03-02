<?php

namespace App\Livewire\Panel\Greenhouses;

use App\Models\Company;
use App\Models\Greenhouse;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowGreenhouse extends Component
{
    public $greenhouse;

    public $operationLicence;
    public $image;

    protected $listeners = [
        'showInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];


    public function initialization($id): void
    {
        $this->reset();
        $this->greenhouse = collect(Greenhouse::query()->find($id));
        $this->image = $this->greenhouse->get('image');
        $this->operationLicence = $this->greenhouse->get('operation_licence');
    }

    public function mount(): void
    {
        abort_if(!Gate::allows(Greenhouse::GREENHOUSE_INDEX), 403);
    }

    public function render()
    {
        return view('livewire.panel.greenhouses.show-greenhouse');
    }
}
