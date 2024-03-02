<?php

namespace App\Livewire\Panel\Users;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    public function mount()
    {
        abort_if(!auth()->user()->isActive(), 403);
        abort_if(!Gate::allows(User::USER_INDEX), 403);
    }

    #[Layout('livewire.panel.layouts.app')]
    public function render()
    {
        return view('livewire.panel.users.index');
    }
}
