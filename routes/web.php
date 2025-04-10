<?php

use App\Livewire\Blogs;
use App\Livewire\BlogView;
use App\Livewire\Home;
use App\Livewire\Product\Index as Products;
use App\Livewire\Product\Details as ProductsDetails;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/products', Products::class)->name('products');
Route::get('/products/{slug}', ProductsDetails::class)->name('products.view');
Route::get('/contact', Home::class)->name('contact');
Route::get('/blogs', Blogs::class)->name('blogs');
Route::get('/blogs/{slug}', BlogView::class)->name('blogs.view');
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
