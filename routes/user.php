<?php

use App\Livewire\User;
use App\Livewire\User\Downloads;
use App\Livewire\User\Orders;
use App\Livewire\User\Profile;
use App\Livewire\User\Reviews;

// Dashboard
Route::get('', User::class)->name('index');
Route::get('dashboard', User::class)->name('dashboard');
Route::get('profile', Profile::class)->name('profile');
Route::get('orders', Orders::class)->name('orders');
Route::get('reviews', Reviews::class)->name('reviews');
Route::get('downloads', Downloads::class)->name('downloads');
