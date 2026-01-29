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
     */
    public function boot(): void
    {
        $url = env('APP_URL', 'http://localhost:5501');
        if (str_starts_with($url, 'https://')) {
            URL::forceScheme('https');
        }
    }
}
