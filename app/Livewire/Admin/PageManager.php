<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use Livewire\Component;

class PageManager extends Component
{
    use LivewireToast;
    public function render()
    {
        return view('livewire.admin.page-manager')
        ->layout('admin.layouts.app');
    }
}
