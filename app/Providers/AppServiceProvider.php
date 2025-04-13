<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\CarbonImmutable;
use Date;
use Illuminate\Database\Eloquent\Model;
use View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        Model::shouldBeStrict(!app()->isProduction());
        Date::use(CarbonImmutable::class);
        View::share('settings', get_setting());
    }
}
