<?php

namespace App\Livewire\Auth;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class VerifyEmail extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->email_verify) {
            $this->redirectIntended(default: route('user.dashboard'), navigate: true);

            return;
        }

        $user->sendEmailVerification();

        // Flash success message
        Session::flash('status', 'verification-link-sent');
        $this->successAlert('Email verification link sent successfully!');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    public function mount()
    {
        $user = Auth::user();
        if ($user->email_verify || ! sys_setting('verify_email')) {
            $this->successAlert('Your email is already verified!');
            $this->redirectIntended(default: route('user.dashboard'), navigate: true);

            return;
        }
    }
}
