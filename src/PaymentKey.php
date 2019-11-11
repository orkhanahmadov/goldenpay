<?php

namespace Orkhanahmadov\Goldenpay;

class PaymentKey
{
    /**
     * @var int
     */
    private $code;
    /**
     * @var string
     */
    private $message;
    /**
     * @var string|null
     */
    private $key;
    /**
     * PaymentKey constructor.
     *
     * @param int         $code
     * @param string      $message
     * @param string|null $key
     */
    public function __construct(int $code, string $message, ?string $key)
    {
        $this->code = $code;
        $this->message = $message;
        $this->key = $key;
    }

    /**
     * @return string
     */
    public function paymentUrl(): string
    {
        return 'https://rest.goldenpay.az/web/paypage?payment_key='.$this->key;
    }

    /**
     * @return int
     */
    public function getCode(): int
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * @return string|null
     */
    public function getKey(): ?string
    {
        return $this->key;
    }
}
