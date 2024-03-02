<?php

namespace App\Livewire\Panel\Auth;

use Livewire\Component;

class Logout extends Component
{
    public function logout()
    {
        auth()->logout();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.panel.auth.logout');
    }
}
