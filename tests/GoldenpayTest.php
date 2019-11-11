<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;
use Orkhanahmadov\Goldenpay\PaymentKey;

class GoldenpayTest extends TestCase
{
    use UsesGuzzler;

    public function testPaymentKeyMethodReturnsNewPaymentKey()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::API_BASE_URL . 'getPaymentKey')
            ->willRespond(new Response(200, [], $this->jsonFixture('payment_key')));

        $paymentKey = $this->goldenpay->paymentKey(
            100,
            'v',
            'test description'
        );

        $this->assertEquals(1, $paymentKey->getCode());
        $this->assertEquals('success', $paymentKey->getMessage());
        $this->assertEquals('1234-5678', $paymentKey->getKey());
        $this->assertEquals('https://rest.goldenpay.az/web/paypage?payment_key=1234-5678', $paymentKey->paymentUrl());
    }

    public function testPaymentKeyThrowsExceptionIfInvalidCredentialsGiven()
    {
        $this->guzzler
            ->expects($this->once())
            ->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey')
            ->willRespond(new Response(200, [], $this->jsonFixture('payment_key_error')));

        $this->expectException(GoldenpayPaymentKeyException::class);
        $this->expectExceptionMessage('Error message here. Code: 801');

        $this->goldenpay->paymentKey(
            100,
            'v',
            'invalid description'
        );
    }

    public function testPaymentResultMethodReturnsPaymentInformationWithStringPaymentKey()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::API_BASE_URL . 'getPaymentResult')
            ->willRespond(new Response(200, [], $this->jsonFixture('successful_payment')));

        $result = $this->goldenpay->paymentResult('valid_payment_key');

        $this->assertEquals(1, $result->getPaymentKey()->getCode());
        $this->assertEquals('success', $result->getPaymentKey()->getMessage());
        $this->assertEquals('1234-5678', $result->getPaymentKey()->getKey());
        $this->assertEquals('valid_merchant_name', $result->getMerchantName());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals(1, $result->getCheckCount());
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->getPaymentDate());
        $this->assertEquals('2019-04-30 14:16:58', $result->getPaymentDate()->format('2019-04-30 14:16:58'));
        $this->assertEquals('422865******8101', $result->getCardNumber());
        $this->assertEquals('lv', $result->getLanguage());
        $this->assertEquals('test desc', $result->getDescription());
        $this->assertEquals('12345678', $result->getRrn());
    }

    public function testPaymentResultMethodReturnsPaymentInformationWithPaymentKeyInstance()
    {
        $this->guzzler
            ->expects($this->once())
            ->post(self::API_BASE_URL . 'getPaymentResult')
            ->willRespond(new Response(200, [], $this->jsonFixture('successful_payment')));
        $paymentKey = new PaymentKey(1, 'whatever', 'valid_payment_key');

        $result = $this->goldenpay->paymentResult($paymentKey);

        $this->assertEquals(1, $result->getPaymentKey()->getCode());
        $this->assertEquals('success', $result->getPaymentKey()->getMessage());
        $this->assertEquals('1234-5678', $result->getPaymentKey()->getKey());
        $this->assertEquals('valid_merchant_name', $result->getMerchantName());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals(1, $result->getCheckCount());
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->getPaymentDate());
        $this->assertEquals('2019-04-30 14:16:58', $result->getPaymentDate()->format('2019-04-30 14:16:58'));
        $this->assertEquals('422865******8101', $result->getCardNumber());
        $this->assertEquals('lv', $result->getLanguage());
        $this->assertEquals('test desc', $result->getDescription());
        $this->assertEquals('12345678', $result->getRrn());
    }
}
