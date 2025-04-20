<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use LivewireToast;
    use WithFileUploads;
    public function render()
    {
        return view('livewire.admin.settings-manager')
        ->layout('admin.layouts.app');
    }
}
