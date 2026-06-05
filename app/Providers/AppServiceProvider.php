<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

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
     *
     * NOTE: This method previously ran database migrations, seeded permissions,
     * recreated roles and provisioned hard-coded admin users on EVERY request.
     * That was a serious performance and security problem. All of that setup now
     * lives in the database seeders (see Database\Seeders) and is executed once
     * at deploy time via `php artisan migrate --force && php artisan db:seed --force`.
     */
    public function boot(): void
    {
        // Force HTTPS everywhere except local development.
        if (! app()->environment('local', 'development')) {
            URL::forceScheme('https');
        }
    }
}
