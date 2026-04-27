<?php

namespace App\Providers;
use App\Services\Implements\RoleService;
use App\Services\Implements\StoreService;
use App\Services\Implements\UserService;
use App\Services\Interfaces\RoleInterface;
use App\Services\Interfaces\StoreInterface;
use App\Services\Interfaces\UserInterface;
use Illuminate\Support\ServiceProvider;

// Service Interfaces

// Service classes


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
