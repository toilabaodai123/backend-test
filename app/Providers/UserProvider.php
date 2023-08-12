<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserHelperInterface;
use App\Contracts\UserServiceInterface;
use App\Services\UserService;
use App\Helpers\UserHelper;

class UserProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserHelperInterface::class,UserHelper::class);
        $this->app->bind(UserServiceInterface::class,UserService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
