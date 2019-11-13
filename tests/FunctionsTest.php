<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use Orkhanahmadov\Goldenpay\Goldenpay;

class FunctionsTest extends TestCase
{
    public function testGoldenpayFunction()
    {
        $instance = goldenpay('valid_key', 'valid_merchant');

        $this->assertInstanceOf(Goldenpay::class, $instance);
        $this->assertSame('valid_key', $instance->getAuthKey());
        $this->assertSame('valid_merchant', $instance->getMerchantName());
    }
}
