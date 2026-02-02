<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;

// Service Interfaces
use App\Interfaces\RoleInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\StoreInterface;

// Service classes
use App\Services\RoleService;
use App\Services\UserService;
use App\Services\StoreService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserInterface::class, UserService::class);
        $this->app->bind(RoleInterface::class, RoleService::class);
        $this->app->bind(StoreInterface::class, StoreService::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
