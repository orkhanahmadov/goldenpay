<?php

namespace Orkhanahmadov\Goldenpay\Response;

class PaymentKey extends Response
{
    private const PAYMENT_PAGE = 'https://rest.goldenpay.az/web/paypage?payment_key=';

    /**
     * @var string
     */
    private $paymentKey;

    /**
     * PaymentKey constructor.
     *
     * @param string      $paymentKey
     * @param int|null    $code
     * @param string|null $message
     */
    public function __construct(string $paymentKey, ?int $code = null, ?string $message = null)
    {
        parent::__construct($code, $message);

        $this->paymentKey = $paymentKey;
    }

    /**
     * @return string
     */
    public function paymentUrl(): string
    {
        return self::PAYMENT_PAGE.$this->paymentKey;
    }

    /**
     * @return string
     */
    public function getPaymentKey(): string
    {
        return $this->paymentKey;
    }
}
