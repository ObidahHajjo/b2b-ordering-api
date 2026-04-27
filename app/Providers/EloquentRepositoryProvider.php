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
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthEloquent::class);
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
