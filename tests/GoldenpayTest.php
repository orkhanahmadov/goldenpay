<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;

class GoldenpayTest extends TestCase
{
    use UsesGuzzler;

    public function testNewPaymentKeyMethodReturnsNewPaymentKey()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::API_BASE_URL . 'getPaymentKey')
            ->willRespond(new Response(200, [], $this->jsonFixture('payment_key')));

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

    public function testNewPaymentKeyThrowsExceptionIfInvalidCredentialsGiven()
    {
        $this->guzzler
            ->expects($this->once())
            ->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey')
            ->willRespond(new Response(200, [], $this->jsonFixture('payment_key_error')));

        $this->expectException(GoldenpayPaymentKeyException::class);
        $this->expectExceptionMessage('Error message here. Code: 801');

        $this->goldenpay->newPaymentKey(
            100,
            'v',
            'invalid description'
        );
    }

    public function testCheckPaymentResultMethodReturnsPaymentInformation()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::API_BASE_URL . 'getPaymentResult')
            ->willRespond(new Response(200, [], $this->jsonFixture('successful_payment')));

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
