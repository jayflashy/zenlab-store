<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\PaymentController;
use App\Livewire\Blogs;
use App\Livewire\BlogView;
use App\Livewire\Cart\Checkout;
use App\Livewire\Cart\Index as Cart;
use App\Livewire\Cart\Success as PaymentSuccess;
use App\Livewire\Contact;
use App\Livewire\Home;
use App\Livewire\Product\Details as ProductsDetails;
use App\Livewire\Product\Index as Products;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User;
use Illuminate\Support\Facades\Route;

Route::get('/', Home::class)->name('home');
Route::get('/products', Products::class)->name('products');
Route::get('/products/{slug}', ProductsDetails::class)->name('products.view');
Route::get('/contact', Contact::class)->name('contact');
Route::get('/blogs', Blogs::class)->name('blogs');
Route::get('/blogs/{slug}', BlogView::class)->name('blogs.view');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/shop', Home::class)->name('shop');
Route::get('payment/success/{order_id?}', PaymentSuccess::class)->name('payment.success');
// pages
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/policy', [PageController::class, 'policy'])->name('policy');
Route::get('/terms', [PageController::class, 'terms'])->name('terms');
Route::get('/pages/{slug}', [PageController::class, 'show'])->name('pages.view');

Route::get('user', User::class)->name('user.index');

Route::get('dashboard', User::class)->name('dashboard');

// Route::view('dashboard', 'dashboard')
//     ->middleware(['auth', 'verified'])
//     ->name('dashboard');

Route::middleware(['auth'])->group(function (): void {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

require __DIR__ . '/auth.php';

Route::prefix('admin')->as('admin.')->group(function (): void {
    require __DIR__ . '/admin.php';
});

// Payment Callback
Route::controller(PaymentController::class)->group(function () {
    Route::any('/paystack/success/', 'paystackSuccess')->name('paystack.success');
    Route::any('/flutter/success/', 'flutterSuccess')->name('flutter.success');
    Route::any('/monnify/success/', 'monnifySuccess')->name('monnify.success');
});
