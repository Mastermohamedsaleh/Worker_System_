<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;


use App\Payment\StripePayment;
use App\Payment\PaymentInterface;
use App\Http\Controllers\PaymentController;



class PaymentProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(PaymentController::class)
        ->needs(PaymentInterface::class)
        ->give(function () {
            return  new StripePayment();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
