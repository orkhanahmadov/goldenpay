<?php

namespace Orkhanahmadov\Goldenpay;

class PaymentKey
{
    /**
     * @var int
     */
    public $code;
    /**
     * @var string
     */
    public $message;
    /**
     * @var string|null
     */
    public $paymentKey;

    /**
     * PaymentKey constructor.
     *
     * @param int         $code
     * @param string      $message
     * @param string|null $paymentKey
     */
    public function __construct(int $code, string $message, ?string $paymentKey)
    {
        $this->code = $code;
        $this->message = $message;
        $this->paymentKey = $paymentKey;
    }

    public function paymentUrl(): string
    {
        return 'https://rest.goldenpay.az/web/paypage?payment_key='.$this->paymentKey;
    }
}
