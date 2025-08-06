<?php

namespace App\Livewire\Admin;

use App\Traits\LivewireToast;
use App\Traits\SettingsTrait;
use Exception;
use Illuminate\Http\Request;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layouts.app')]
class EmailSetting extends Component
{
    use LivewireToast;
    use SettingsTrait;

    public $email_gateway;

    public $settings = [];

    public $test_email;

    public function mount(): void
    {
        $this->email_gateway = sys_setting('email_gateway') ?? 'php';

        $this->settings = [
            'MAIL_MAILER' => env('MAIL_MAILER'),
            'MAIL_SCHEME' => env('MAIL_SCHEME'),
            'MAIL_HOST' => env('MAIL_HOST'),
            'MAIL_PORT' => env('MAIL_PORT'),
            'MAIL_USERNAME' => env('MAIL_USERNAME'),
            'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
            'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),
            'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
            'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
        ];
    }

    public function updateSettings(Request $request): void
    {
        $this->validate([
            'email_gateway' => 'required|in:php,smtp',
        ]);

        // Update to system settings (Database)
        $this->systemSetUpdate((object) [
            'name' => 'email_gateway',
            'value' => $this->email_gateway,
        ]);

        // Update ENV settings
        foreach ($this->settings as $key => $value) {
            $this->overWriteEnvFile($key, $value);
        }

        $this->successAlert('Email settings updated successfully.', 'Settings Saved');
    }

    public function sendTestEmail(): void
    {
        $this->validate([
            'test_email' => 'required|email',
        ]);

        try {

            $this->toast('success', 'Test email sent successfully!', 'success');
        } catch (Exception $exception) {
            $this->toast('error', 'Failed to send test email: ' . $exception->getMessage(), 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.email-setting');
    }
}
