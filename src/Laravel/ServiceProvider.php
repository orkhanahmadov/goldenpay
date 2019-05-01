<?php

namespace Orkhanahmadov\Goldenpay\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Orkhanahmadov\Goldenpay\Goldenpay;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/goldenpay.php.stub' => config_path('goldenpay.php'),
        ], 'config');

        $this->app->singleton('Goldenpay', function ($app) {
            return new Goldenpay(config('goldenpay.auth_key'), config('goldenpay.merchant_name'));
        });
    }

    public function register()
    {
        //
    }
}
