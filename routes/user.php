<?php

use App\Livewire\User;

// Dashboard
Route::get('user', User::class)->name('index');

Route::get('dashboard', User::class)->name('dashboard');
