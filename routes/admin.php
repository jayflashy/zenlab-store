<?php

use App\Http\Controllers\Admin\BlogController;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Dashboard;

// Auth;

Route::middleware('admin')->group(function (): void {
    // Dashboard
    Route::get('', Dashboard::class)->name('index');
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // categories
    Route::get('categories', CategoryManager::class)->name('categories');

    // Blogs
    Route::resource('blogs2', BlogController::class)->names('blogs');
});
