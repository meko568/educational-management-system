<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Force HTTPS only if behind a proper proxy
        if (config('app.env') === 'production' && isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
            URL::forceScheme('https');
        }

        if (app()->getLocale() === 'ar') {
            app('view.finder')->prependLocation(resource_path('views/ar'));
        }
    }
}