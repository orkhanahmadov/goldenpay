<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use Orkhanahmadov\Goldenpay\GoldenpayServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpDatabase($this->app);
    }

    /**
     * @param \Illuminate\Foundation\Application $app
     */
    protected function setUpDatabase( $app)
    {
        include_once __DIR__.'/../src/database/migrations/create_goldenpay_payments_table.php.stub';
        (new \CreateGoldenpayPaymentsTable())->up();

        include_once __DIR__.'/../src/database/migrations/create_goldenpay_payment_keys_table.php.stub';
        (new \CreateGoldenpayPaymentKeysTable())->up();
    }

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
            GoldenpayServiceProvider::class
        ];
    }

    /**
     * Define environment setup.
     *
     * @param  \Illuminate\Foundation\Application   $app
     *
     * @return void
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'test_db');
        $app['config']->set('database.connections.test_db', [
            'driver' => 'sqlite',
            'database' => ':memory:'
        ]);
    }
}
