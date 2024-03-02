<?php

namespace App\Livewire;

use App\Models\Config;
use App\Services\SMS\smsService;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Home extends Component
{
    #[Layout('livewire.layouts.app')]
    public function render()
    {
        return view('livewire.home');
    }
}
