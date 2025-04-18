<?php

use App\Livewire\Admin\BlogManager;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\PageManager;

// Auth;

Route::middleware('admin')->group(function (): void {
    // Dashboard
    Route::get('', Dashboard::class)->name('index');
    Route::get('dashboard', Dashboard::class)->name('dashboard');

    // categories
    Route::get('categories', CategoryManager::class)->name('categories');

    // Blogs
    Route::get('blogs', BlogManager::class)->name('blogs');
    Route::get('/blogs/create', BlogManager::class)->name('blogs.create');
    Route::get('/blogs/edit/{id}', BlogManager::class)->name('blogs.edit');

    // Pages
    Route::get('pages', PageManager::class)->name('pages');
    Route::get('/pages/create', PageManager::class)->name('pages.create');
    Route::get('/pages/edit/{id}', PageManager::class)->name('pages.edit');
});
