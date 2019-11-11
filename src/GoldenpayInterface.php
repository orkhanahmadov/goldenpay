<?php

namespace Orkhanahmadov\Goldenpay;

interface GoldenpayInterface
{
    /**
     * Generates new payment key.
     *
     * @param int $amount
     * @param string $cardType
     * @param string $description
     * @param string $lang
     *
     * @return PaymentKey
     */
    public function paymentKey(int $amount, string $cardType, string $description, string $lang = 'lv'): PaymentKey;

    /**
     * Checks result of payment using existing payment key.
     *
     * @param PaymentKey|string $paymentKey
     *
     * @return PaymentResult
     */
    public function paymentResult($paymentKey): PaymentResult;
}
