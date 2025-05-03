<?php

use App\Http\Controllers\DownloadController;
use App\Livewire\User;
use App\Livewire\User\Downloads;
use App\Livewire\User\Invoice;
use App\Livewire\User\Orders;
use App\Livewire\User\Profile;
use App\Livewire\User\Reviews;

// Dashboard
Route::get('', User::class)->name('index');
Route::get('dashboard', User::class)->name('dashboard');
Route::get('profile', Profile::class)->name('profile');
Route::get('orders', Orders::class)->name('orders');
Route::get('orders/{code}', Orders::class)->name('orders.view');
Route::get('orders/{code}/invoice', Invoice::class)->name('orders.invoice');

Route::get('reviews', Reviews::class)->name('reviews');
Route::get('downloads', Downloads::class)->name('downloads');
Route::get('download/{id}', [DownloadController::class, 'download'])->name('download');
