<?php

namespace Orkhanahmadov\Goldenpay;

use Orkhanahmadov\Goldenpay\Enums\CardType;
use Orkhanahmadov\Goldenpay\Enums\Language;

interface PaymentInterface
{
    /**
     * Sets Goldenpay authentication credentials.
     *
     * @param string $authKey
     * @param string $merchantName
     *
     * @return self
     */
    public function auth(string $authKey, string $merchantName): self;

    /**
     * Generates new payment key.
     *
     * @param int $amount
     * @param CardType $cardType
     * @param string $description
     * @param Language $lang
     *
     * @return PaymentKey
     */
    public function paymentKey(int $amount, CardType $cardType, string $description, ?Language $lang): PaymentKey;

    /**
     * Checks result of payment using existing payment key.
     *
     * @param PaymentKey|string $paymentKey
     *
     * @return PaymentResult
     */
    public function paymentResult($paymentKey): PaymentResult;
}
