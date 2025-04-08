<?php

use App\Livewire\Home;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/products', Home::class)->name('products');
Route::get('/contact', Home::class)->name('contact');
Route::get('/blogs', Home::class)->name('blogs');
Route::get('/blogs/{slug}', Home::class)->name('blogs.view');
Route::get('/cart', Home::class)->name('cart');
Route::get('/', Home::class)->name('home');
Route::get('/', Home::class)->name('home');




Route::get('user', User::class)->name('user.index');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__.'/auth.php';
