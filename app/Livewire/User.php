<?php

namespace App\Livewire;

use App\Traits\LivewireToast;
use Livewire\Component;

class User extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.user')
            ->layout('user.layouts.app');
    }
}
