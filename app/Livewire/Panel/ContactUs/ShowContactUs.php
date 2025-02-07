<?php

namespace App\Livewire\Panel\ContactUs;

use App\Models\Company;
use App\Models\ContactUs;
use Illuminate\Support\Facades\Gate;
use Livewire\Component;

class ShowContactUs extends Component
{
    public $contactUs;

    protected $listeners = [
        'showInitialize' => 'initialization',
        'refresh' => '$refresh'
    ];

    public function initialization($id): void
    {
        $this->reset();
        $this->contactUs = collect(ContactUs::query()->find($id));
    }

    public function mount(): void
    {
        abort_if(!Gate::allows(ContactUs::CONTACT_US_INDEX), 403);
    }

    public function render()
    {
        return view('livewire.panel.contact-us.show-contact-us');
    }
}
