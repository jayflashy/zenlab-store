<?php

namespace App\Livewire\Auth;

use App\Traits\LivewireToast;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Component;

#[Layout('layouts.auth')]
class ResetPassword extends Component
{
    use LivewireToast;

    #[Locked]
    public string $token = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::min(8)->mixedCase()->numbers()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user): void {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                sendNotification('PASSWORD_CHANGED', $user, [
                    'user_name' => $user->name,
                    'change_time' => now()->format('Y-m-d H:i:s'),
                    'reset_link' => route('login'),
                ]);
                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PasswordReset) {
            $this->addError('email', __($status));
            $this->errorAlert('Password Reset Failed');

            return;
        }

        $this->successAlert('Password Reset Successfully');
        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}
