<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;


// Eloquent interfaces
use App\Repositories\Interfaces\RoleInterface;
use App\Repositories\Interfaces\StoreInterface;
use App\Repositories\Interfaces\UserInterface;

// Eloquent Repositories
use App\Repositories\Eloquents\StoreEloquent;
use App\Repositories\Eloquents\UserEloquent;
use App\Repositories\Eloquents\RoleEloquent;

class EloquentRepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(RoleInterface::class, RoleEloquent::class);
        $this->app->bind(UserInterface::class, UserEloquent::class);
        $this->app->bind(StoreInterface::class, StoreEloquent::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
