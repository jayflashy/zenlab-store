<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if (! $user->email_verify && sys_setting('verify_email') == 1) {
            return to_route('verification.notice');
        }
        if (! $user->is_active) {
            Auth::logout();

            return to_route('login')->withError('Your account has been disabled or suspended');
        }

        return $next($request);
    }
}
