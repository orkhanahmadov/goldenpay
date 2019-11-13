<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use Orkhanahmadov\Goldenpay\Goldenpay;

class TestCase extends \PHPUnit\Framework\TestCase
{
    use UsesGuzzler;

    const API_BASE_URL = 'https://rest.goldenpay.az/web/service/merchant/';
    /**
     * @var Goldenpay
     */
    protected $goldenpay;

    protected function setUp(): void
    {
        parent::setUp();

        $this->goldenpay = new Goldenpay();
        $this->goldenpay->auth('valid_auth_key', 'valid_merchant_name');

        $reflection = new \ReflectionClass(Goldenpay::class);
        $reflectionProp = $reflection->getProperty('client');
        $reflectionProp->setAccessible(true);
        $reflectionProp->setValue($this->goldenpay, $this->guzzler->getClient(['base_uri' => self::API_BASE_URL]));
    }

    protected function jsonFixture(string $fileName): string
    {
        return file_get_contents(__DIR__.'/__fixtures__/'.$fileName.'.json');
    }
}
