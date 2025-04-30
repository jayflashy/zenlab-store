<?php

namespace App\Livewire\User;

use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('user.layouts.app')]
class Profile extends Component
{
    use LivewireToast;
    public function render()
    {
        return view('livewire.user.profile');
    }
}
