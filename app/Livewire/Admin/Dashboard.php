<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use Livewire\Component;

class Dashboard extends Component
{
    use LivewireToast;

    public function render()
    {
        return view('livewire.admin.dashboard')
            ->layout('admin.layouts.app');
    }
}
