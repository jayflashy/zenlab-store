<?php

namespace App\Livewire\User;

use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class Profile extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.user.profile');
    }
}
