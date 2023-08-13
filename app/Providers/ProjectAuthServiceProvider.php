<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\AuthHelperInterface;
use App\Contracts\AuthServiceInterface;
use App\Services\AuthService;
use App\Helpers\AuthHelper;

class ProjectAuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(AuthHelperInterface::class,AuthHelper::class);
        $this->app->bind(AuthServiceInterface::class,AuthService::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
