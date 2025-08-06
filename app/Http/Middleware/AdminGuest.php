<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminGuest
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (\Auth::guard('admin')->check()) {
            if (session('admin_link') != null) {
                return redirect(session('admin_link'));
            }

            return to_route('admin.dashboard');
        }

        return $next($request);
    }
}
