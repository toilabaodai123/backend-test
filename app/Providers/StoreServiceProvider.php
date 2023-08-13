<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\StoreServiceInterface;
use App\Services\StoreService;
use App\Contracts\StoreHelperInterface;
use App\Helpers\StoreHelper;
use App\Contracts\StoreRepositoryInterface;
use App\Repositories\StoreRepository;

/**
 * StoreProvider
 */
class StoreServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(StoreHelperInterface::class,StoreHelper::class);
        $this->app->bind(StoreServiceInterface::class, StoreService::class);
        $this->app->bind(StoreRepositoryInterface::class,StoreRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
