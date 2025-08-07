<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use RateLimiter;

#[Layout('layouts.auth')]
class ForgotPassword extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        // Add rate limiting
        if (method_exists($this, 'throttle')) {
            $this->throttle(1, 1, 'password-reset');
        }

        $user = User::where('email', $this->email)->first();
        if ($user) {
            $token = Password::createToken($user);

            $resetLink = url(route('password.reset', [
                'token' => $token,
                'email' => $user->getEmailForPasswordReset(),
            ], false));

            sendNotification('PASSWORD_RESET', $user, [
                'user_name' => $user->name,
                'email' => $user->email,
                'reset_link' => $resetLink,
            ], [
                'link' => $resetLink,
                'link_text' => 'Reset Password',
            ]);
        }
        session()->flash('status', __('A reset link will be sent if the account exists.'));

        $this->successAlert('A reset link will be sent if the account exists.');
    }

    /**
     * Rate limit the password reset process.
     */
    protected function throttle($attempts, $decay, $key): void
    {
        $this->ensureIsNotRateLimited($attempts, $decay, $key);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited($attempts, $decay, $key): void
    {
        if (! RateLimiter::tooManyAttempts($key, $attempts)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($key);

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }
}
