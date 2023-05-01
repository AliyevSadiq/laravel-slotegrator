<?php

namespace App\Providers;

use App\Utils\Manager\StorageManager;
use App\Utils\Manager\StorageManagerInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->singleton(StorageManagerInterface::class,StorageManager::class);
    }
}
