<?php

namespace App\Livewire;

use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Component;

class AboutUs extends Component
{
    public null|Collection $about;

    public function mount(): void
    {
        $about = \App\Models\AboutUs::query()->first();
        $this->about = collect($about);
    }

    #[Layout('livewire.panel.auth.layouts.app')]
    public function render()
    {
        return view('livewire.about-us');
    }
}
