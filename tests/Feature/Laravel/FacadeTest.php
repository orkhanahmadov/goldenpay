<?php

namespace Orkhanahmadov\Goldenpay\Tests\Feature\Laravel;

use Orkhanahmadov\Goldenpay\Laravel\Facades\Goldenpay;
use Orkhanahmadov\Goldenpay\Tests\TestCase;

class FacadeTest extends TestCase
{
    public function test_goldenpay_facade()
    {
        $instance = Goldenpay::getFacadeRoot();

        $this->assertEquals('custom_auth_key', $instance->authKey);
        $this->assertEquals('custom_merchant_name', $instance->merchantName);
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('goldenpay.auth_key', 'custom_auth_key');
        $app['config']->set('goldenpay.merchant_name', 'custom_merchant_name');
    }
}
