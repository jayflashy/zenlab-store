<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use App\Traits\SettingsTrait;
use Livewire\Component;
use Livewire\WithFileUploads;

class SettingsManager extends Component
{
    use LivewireToast;
    use SettingsTrait;
    use WithFileUploads;

    public $view;

    public $gateways = [];

    public $sysSettings = [];

    public function mount($type = 'index')
    {
        $this->view = 'index';
        if ($type == 'payments') {
            $this->showPayment();
        }
        if ($type == 'others') {
            $this->view = 'others';
        }
    }

    public function showPayment()
    {
        $this->gateways = [
            ['name' => 'Paypal', 'key' => 'paypal_payment'],
            ['name' => 'Paystack', 'key' => 'paystack_payment'],
            ['name' => 'Flutterwave', 'key' => 'flutterwave_payment'],
            ['name' => 'Cryptomus', 'key' => 'cryptomus_payment'],
            ['name' => 'Manual', 'key' => 'manual_payment'],
        ];

        foreach ($this->gateways as $gateway) {
            $this->sysSettings[$gateway['key']] = (bool) sys_setting($gateway['key']);
        }
        $this->view = 'payments';
    }

    public function updatedSysSettings($value, $key)
    {
        $this->systemSetUpdate(
            (object) [
                'name' => $key,
                'value' => $value,
            ]
        );
        $this->successAlert('Settings updated successfully.', 'Settings Saved');
    }

    public function render()
    {
        return view('livewire.admin.settings-manager')
            ->layout('admin.layouts.app');
    }
}
