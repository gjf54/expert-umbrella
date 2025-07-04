<?php

namespace App\Providers;

use App\Contracts\OrderStatusManagerContract;
use App\Modules\OrderStatusManager;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(OrderStatusManagerContract::class, OrderStatusManager::class);
    }
}
