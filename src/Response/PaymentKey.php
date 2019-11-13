<?php

namespace Orkhanahmadov\Goldenpay\Response;

class PaymentKey extends Response
{
    public const PAYMENT_PAGE = 'https://rest.goldenpay.az/web/paypage?payment_key=';

    /**
     * @var string
     */
    private $paymentKey;

    /**
     * PaymentKey constructor.
     *
     * @param int    $code
     * @param string $message
     * @param string $paymentKey
     */
    public function __construct(int $code, string $message, string $paymentKey)
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
