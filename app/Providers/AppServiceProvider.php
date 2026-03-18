<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use   App\Repository\Orders\OrderRepositoryinterface;
use   App\Repository\Orders\OrderRepository;




class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderRepositoryinterface::class,OrderRepository::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
