<?php

namespace Orkhanahmadov\Goldenpay;

interface GoldenpayInterface
{
    public function newPaymentKey(int $amount, string $cardType, string $description, string $lang = 'lv'): PaymentKey;

    public function checkPaymentResult(string $paymentKey): PaymentResult;
}
