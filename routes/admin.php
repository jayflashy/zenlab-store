<?php

use App\Http\Controllers\Admin\SettingsController;
use App\Livewire\Admin\BlogManager;
use App\Livewire\Admin\CategoryManager;
use App\Livewire\Admin\CouponManager;
use App\Livewire\Admin\Dashboard;
use App\Livewire\Admin\EmailSetting;
use App\Livewire\Admin\EmailTemplate;
use App\Livewire\Admin\LicenseManager;
use App\Livewire\Admin\OrderManager;
use App\Livewire\Admin\PageManager;
use App\Livewire\Admin\Products\Comments as ProductComments;
use App\Livewire\Admin\Products\ProductForm;
use App\Livewire\Admin\Products\ProductList;
use App\Livewire\Admin\Products\Ratings;
use App\Livewire\Admin\SettingsManager;
use App\Livewire\Admin\UserManager;
use App\Livewire\Admin\UserView;

// Auth;

Route::middleware('admin')->group(function (): void {
    // Dashboard
    Route::get('', Dashboard::class)->name('index');
    Route::get('dashboard', Dashboard::class)->name('dashboard');
    // categories
    Route::get('categories', CategoryManager::class)->name('categories');
    // license
    Route::get('license', LicenseManager::class)->name('license');
    // Products
    Route::get('products', ProductList::class)->name('products.index');
    Route::get('products/create', ProductForm::class)->name('products.create');
    Route::get('products/edit/{id}', ProductForm::class)->name('products.edit');
    Route::get('products/comments', ProductComments::class)->name('products.comments');
    Route::get('products/ratings', Ratings::class)->name('products.ratings');
    // coupons
    Route::get('coupons', CouponManager::class)->name('coupons');
    // orders
    Route::get('orders', OrderManager::class)->name('orders');
    Route::get('orders/{id}', OrderManager::class)->name('orders.show');
    // users
    Route::get('users', UserManager::class)->name('users');
    Route::get('users/{id}', UserView::class)->name('users.show');

    // Blogs
    Route::get('blogs', BlogManager::class)->name('blogs');
    Route::get('/blogs/create', BlogManager::class)->name('blogs.create');
    Route::get('/blogs/edit/{id}', BlogManager::class)->name('blogs.edit');

    // Pages
    Route::get('pages', PageManager::class)->name('pages');
    Route::get('/pages/create', PageManager::class)->name('pages.create');
    Route::get('/pages/edit/{id}', PageManager::class)->name('pages.edit');

    // Email Setting
    Route::get('email/settings', EmailSetting::class)->name('email.settings');
    Route::get('email/templates', EmailTemplate::class)->name('email.templates');
    Route::get('email/templates/edit/{id}', EmailTemplate::class)->name('email.templates.edit');

    // general settings
    Route::get('settings/{type?}', SettingsManager::class)->name('settings');
    Route::get('settings/payments', SettingsManager::class)->name('settings.payments');

    Route::controller(SettingsController::class)->as('settings.')->prefix('settings')->group(function (): void {
        Route::post('/update', 'update')->name('update');
        Route::post('/system', 'systemUpdate')->name('sys_settings');
        Route::post('/system/store', 'storeSettings')->name('store_settings');
        Route::post('env_key', 'envkeyUpdate')->name('env_key');
    });
});
