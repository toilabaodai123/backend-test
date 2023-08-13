<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\UserHelperInterface;
use App\Contracts\UserServiceInterface;
use App\Contracts\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Services\UserService;
use App\Helpers\UserHelper;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(UserHelperInterface::class,UserHelper::class);
        $this->app->bind(UserServiceInterface::class,UserService::class);
        $this->app->bind(UserRepositoryInterface::class,UserRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
