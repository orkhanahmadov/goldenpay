<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use Orkhanahmadov\Goldenpay\Laravel\ServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Resolve application aliases.
     *
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            ServiceProvider::class
        ];
    }
}
