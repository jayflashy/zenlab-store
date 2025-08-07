<?php

namespace App\Livewire\Auth;

use App\Models\User;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.auth')]
class Register extends Component
{
    use LivewireToast;

    public string $name = '';

    public string $email = '';

    public string $username;

    public string $password = '';

    public $terms = false;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|lowercase|max:105|unique:users',
            'username' => 'required|string|max:255|unique:users|alpha_dash',
            'password' => [
                'required',
                'string',
                Password::min(8)->mixedCase()->letters()->numbers(),
            ],
            'terms' => 'accepted',
        ];
    }

    protected $messages = [
        'name.required' => 'Please enter your full name.',
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please enter a valid email address.',
        'email.unique' => 'This email is already taken.',
        'username.required' => 'Please enter a username.',
        'username.unique' => 'This username is already taken.',
        'password.required' => 'Please enter a password.',
        'password.min' => 'Password must be at least 6 characters.',
        'terms.accepted' => 'You must agree to the terms and conditions.',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->validate();

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'username' => $this->username,
            'password' => Hash::make($this->password),
            'status' => 'active',
            'email_verify' => 1,
        ]);
        $user->sendEmailVerification();
        Auth::login($user);
        $this->successAlert('Registration Successful');

        $this->redirect(route('user.index'), navigate: true);
    }
}
