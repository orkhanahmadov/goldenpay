<?php

namespace Orkhanahmadov\Goldenpay\Response;

class PaymentKey extends Status
{
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
        $this->code = $code;
        $this->message = $message;
        $this->paymentKey = $paymentKey;
    }

    /**
     * @return string
     */
    public function paymentUrl(): string
    {
        return 'https://rest.goldenpay.az/web/paypage?payment_key='.$this->paymentKey;
    }

    /**
     * @return string
     */
    public function getPaymentKey(): string
    {
        return $this->paymentKey;
    }
}
