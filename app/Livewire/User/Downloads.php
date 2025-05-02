<?php

namespace App\Livewire\User;

use App\Traits\LivewireToast;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('user.layouts.app')]
class Downloads extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.user.downloads');
    }
}
