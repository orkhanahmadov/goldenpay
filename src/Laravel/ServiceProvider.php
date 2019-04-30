<?php

namespace Orkhanahmadov\Goldenpay\Laravel;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/goldenpay.php.stub' => config_path('goldenpay.php'),
        ], 'config');
    }

    public function register()
    {
        //
    }
}
