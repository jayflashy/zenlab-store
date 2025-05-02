<?php

namespace App\Livewire\Auth;

use App\Models\Cart;
use App\Traits\LivewireToast;
use Exception;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Log;

#[Layout('layouts.auth')]
class Login extends Component
{
    use LivewireToast;

    public string $email = '';

    public string $password = '';

    public bool $remember = false;

    protected $rules = [
        'email' => 'required|string|email|lowercase',
        'password' => 'required|string',
    ];

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $oldSession = session()->getId();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        // merge guest cart with user cart
        try {
            Cart::mergeGuestCart(Auth::user()->id, $oldSession);
        } catch (Exception $exception) {
            Log::error('Failed to merge guest cart: ' . $exception->getMessage());
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();
        $this->successAlert('Login Successful');

        $this->redirectIntended(default: route('dashboard'), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
