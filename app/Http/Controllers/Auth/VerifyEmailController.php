<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\RedirectResponse;

class VerifyEmailController extends Controller
{
    /**
     * Mark the authenticated user's email address as verified.
     */
    public function __invoke(EmailVerificationRequest $request): RedirectResponse
    {
        $user = $request->user();
        if ($user->email_verify) {
            session()->flash('success', 'Your email is already verified!');

            return redirect()->intended(route('user.dashboard') . '?verified=1');
        }
        $user->email_verify = true;

        if ($user->isDirty('email_verify')) {
            $user->save();
            // send welcome email
            sendNotification(
                'WELCOME',
                $user,
                [
                    'user_name' => $user->name,
                    'email' => $user->email,
                    'login_link' => route('login'),
                    'products_link' => route('products'),
                ]
            );
        }

        session()->flash('success', 'Your email is verified!');

        return redirect()->intended(route('user.dashboard') . '?verified=1');
    }
}
