<?php

use App\Livewire\Admin\Dashboard;

// Auth;

Route::middleware('admin')->group(function () {
    // Dashboard
    Route::get('', Dashboard::class)->name('index');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
});
