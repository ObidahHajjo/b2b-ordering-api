<?php

namespace App\Providers;

use App\Repositories\Eloquents\AuthEloquent;
use App\Repositories\Eloquents\RoleEloquent;
use App\Repositories\Eloquents\StoreEloquent;
use App\Repositories\Eloquents\UserEloquent;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Repositories\Interfaces\RoleInterface;
use App\Repositories\Interfaces\StoreInterface;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\ServiceProvider;

class EloquentRepositoryProvider extends ServiceProvider
{
    /**
     * Register repository interfaces used by application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthEloquent::class);
        $this->app->bind(RoleInterface::class, RoleEloquent::class);
        $this->app->bind(StoreInterface::class, StoreEloquent::class);
        $this->app->bind(UserInterface::class, UserEloquent::class);
    }

    /**
     * Bootstrap repository services.
     */
    public function boot(): void
    {
        //
    }
}
