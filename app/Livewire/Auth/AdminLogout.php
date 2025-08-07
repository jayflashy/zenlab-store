<?php

namespace App\Livewire\Auth;

use Auth;
use Livewire\Component;
use Session;

class AdminLogout extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function __invoke()
    {
        Auth::guard('admin')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect(route('admin.login'));
    }
}
