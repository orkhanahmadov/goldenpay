<?php

namespace Orkhanahmadov\Goldenpay\Tests\Unit;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;
use Orkhanahmadov\Goldenpay\Goldenpay;
use Orkhanahmadov\Goldenpay\Tests\TestCase;

class GoldenpayTest extends TestCase
{
    use UsesGuzzler;

    /**
     * @var Goldenpay
     */
    private $goldenpay;

    protected function setUp(): void
    {
        parent::setUp();

        $this->goldenpay = new Goldenpay('valid_auth_key', 'valid_merchant_name');
        $this->goldenpay->setClient($this->guzzler->getClient());
    }

    public function test_newPaymentKey_method_returns_new_payment_key()
    {
        $this->guzzler
            ->expects($this->once())
            ->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey')
            ->willRespond(new Response(200, [], '{"status":{"code":1,"message":"success"},"paymentKey":"1234-5678"}'));

        $paymentKey = $this->goldenpay->newPaymentKey(
            100,
            'v',
            'test description'
        );

        $this->assertEquals(1, $paymentKey->code);
        $this->assertEquals('success', $paymentKey->message);
        $this->assertEquals('1234-5678', $paymentKey->paymentKey);
        $this->assertEquals('https://rest.goldenpay.az/web/paypage?payment_key=1234-5678', $paymentKey->paymentUrl());
    }

    public function test_newPaymentKey_throws_exception_if_invalid_credentials_given()
    {
        $this->guzzler
            ->expects($this->once())
            ->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey')
            ->willRespond(new Response(200, [], '{"status":{"code":801,"message":"Error message here"},"paymentKey":null}'));

        $this->expectException(GoldenpayPaymentKeyException::class);
        $this->expectExceptionMessage('Error message here. Code: 801');

        $this->goldenpay->newPaymentKey(
            100,
            'v',
            'invalid description'
        );
    }

    public function test_checkPaymentResult_method_returns_payment_information()
    {
        $this->guzzler
            ->expects($this->once())
            ->post('https://rest.goldenpay.az/web/service/merchant/getPaymentResult')
            ->willRespond(new Response(200, [], '{"status":{"code":1,"message":"success"},"paymentKey":"1234-5678","merchantName":"valid_merchant_name","amount":100,"checkCount":1,"paymentDate":"2019-04-30 14:16:58","cardNumber":"422865******8101","language":"lv","description":"test desc","rrn":"12345678"}'));

        $result = $this->goldenpay->checkPaymentResult('valid_payment_key');

        $this->assertEquals(1, $result->paymentKey->code);
        $this->assertEquals('success', $result->paymentKey->message);
        $this->assertEquals('1234-5678', $result->paymentKey->paymentKey);
        $this->assertEquals('valid_merchant_name', $result->merchantName);
        $this->assertEquals(100, $result->amount);
        $this->assertEquals(1, $result->checkCount);
        $this->assertEquals('2019-04-30 14:16:58', $result->paymentDate);
        $this->assertEquals('422865******8101', $result->cardNumber);
        $this->assertEquals('lv', $result->language);
        $this->assertEquals('test desc', $result->description);
        $this->assertEquals('12345678', $result->rrn);
    }
}
