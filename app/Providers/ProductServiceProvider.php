<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Contracts\ProductServiceInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Contracts\ProductHelperInterface;
use App\Helpers\ProductHelper;
use App\Repositories\ProductRepository;
use App\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(ProductServiceInterface::class,ProductService::class);
        $this->app->bind(ProductRepositoryInterface::class,ProductRepository::class);
        $this->app->bind(ProductHelperInterface::class,ProductHelper::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
