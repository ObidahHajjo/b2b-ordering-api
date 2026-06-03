<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register application services.
     */
    public function register(): void
    {
        config(['sanctum.routes' => false]);
    }

    /**
     * Bootstrap application services.
     */
    public function boot(): void
    {
        //
    }
}
