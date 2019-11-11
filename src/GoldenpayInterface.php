<?php

namespace Orkhanahmadov\Goldenpay;

interface GoldenpayInterface
{
    public function paymentKey(int $amount, string $cardType, string $description, string $lang = 'lv'): PaymentKey;

    public function paymentResult(string $paymentKey): PaymentResult;
}
