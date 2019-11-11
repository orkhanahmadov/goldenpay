<?php

namespace Orkhanahmadov\Goldenpay\Tests;

use BlastCloud\Guzzler\UsesGuzzler;
use GuzzleHttp\Psr7\Response;
use Orkhanahmadov\Goldenpay\Enums\CardType;
use Orkhanahmadov\Goldenpay\Enums\Language;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;

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
            CardType::VISA(),
            'test description',
            Language::AZ()
        );

        $this->assertEquals(1, $paymentKey->getCode());
        $this->assertEquals('success', $paymentKey->getMessage());
        $this->assertEquals('1234-5678', $paymentKey->getPaymentKey());
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
            CardType::VISA(),
            'invalid description'
        );
    }

    public function testPaymentResultMethodReturnsPaymentInformationWithStringPaymentKey()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_BASE_URL . 'getPaymentResult')
            ->willRespond(new Response(200, [], $this->jsonFixture('successful_payment')));

        $result = $this->goldenpay->paymentResult('valid-payment-key');

        $this->assertEquals(1, $result->getCode());
        $this->assertEquals('success', $result->getMessage());
        $this->assertEquals('valid-payment-key', $result->getPaymentKey());
        $this->assertEquals('valid-merchant-name', $result->getMerchantName());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals(1, $result->getCheckCount());
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->getPaymentDate());
        $this->assertEquals('2019-04-30 14:16:58', $result->getPaymentDate()->format('2019-04-30 14:16:58'));
        $this->assertEquals('422865******8101', $result->getCardNumber());
        $this->assertEquals('lv', $result->getLanguage());
        $this->assertEquals('test desc', $result->getDescription());
        $this->assertEquals('12345678', $result->getReferenceNumber());
    }

    public function testPaymentResultMethodReturnsPaymentInformationWithPaymentKeyInstance()
    {
        $this->guzzler
            ->expects($this->once())
            ->get(self::API_BASE_URL . 'getPaymentResult')
            ->willRespond(new Response(200, [], $this->jsonFixture('successful_payment')));

        $result = $this->goldenpay->paymentResult('valid-payment-key');

        $this->assertEquals(1, $result->getCode());
        $this->assertEquals('success', $result->getMessage());
        $this->assertEquals('valid-payment-key', $result->getPaymentKey());
        $this->assertEquals('valid-merchant-name', $result->getMerchantName());
        $this->assertEquals(100, $result->getAmount());
        $this->assertEquals(1, $result->getCheckCount());
        $this->assertInstanceOf(\DateTimeImmutable::class, $result->getPaymentDate());
        $this->assertEquals('2019-04-30 14:16:58', $result->getPaymentDate()->format('2019-04-30 14:16:58'));
        $this->assertEquals('422865******8101', $result->getCardNumber());
        $this->assertEquals('lv', $result->getLanguage());
        $this->assertEquals('test desc', $result->getDescription());
        $this->assertEquals('12345678', $result->getReferenceNumber());
    }
}
