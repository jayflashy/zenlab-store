<?php

namespace App\Livewire;

use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class User extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.user');
    }
}
