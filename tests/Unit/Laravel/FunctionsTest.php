<?php

namespace Orkhanahmadov\Goldenpay\Tests\Unit\Laravel;

use Orkhanahmadov\Goldenpay\Tests\TestCase;

class FunctionsTest extends TestCase
{
    public function test_goldenpay_method()
    {
        $goldenpay = goldenpay();
        $this->assertEquals('custom_auth_key', $goldenpay->authKey);
        $this->assertEquals('custom_merchant_name', $goldenpay->merchantName);

        $goldenpay = goldenpay('another_auth_key', 'another_merchant_name');
        $this->assertEquals('another_auth_key', $goldenpay->authKey);
        $this->assertEquals('another_merchant_name', $goldenpay->merchantName);
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('goldenpay.auth_key', 'custom_auth_key');
        $app['config']->set('goldenpay.merchant_name', 'custom_merchant_name');
    }
}
