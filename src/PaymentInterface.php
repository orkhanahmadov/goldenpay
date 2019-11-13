<?php

namespace Orkhanahmadov\Goldenpay;

use Orkhanahmadov\Goldenpay\Enums\CardType;
use Orkhanahmadov\Goldenpay\Enums\Language;
use Orkhanahmadov\Goldenpay\Response\PaymentKey;
use Orkhanahmadov\Goldenpay\Response\PaymentResult;

interface PaymentInterface
{
    /**
     * Sets Goldenpay authentication credentials.
     *
     * @param string $authKey
     * @param string $merchantName
     *
     * @return PaymentInterface
     */
    public function auth(string $authKey, string $merchantName): self;

    /**
     * Gets new payment key from Goldenpay.
     *
     * @param int      $amount
     * @param CardType $cardType
     * @param string   $description
     * @param Language $lang
     *
     * @return PaymentKey
     */
    public function payment(int $amount, CardType $cardType, string $description, Language $lang): PaymentKey;

    /**
     * Checks result of payment using existing payment key.
     *
     * @param PaymentKey|string $paymentKey
     *
     * @return PaymentResult
     */
    public function result($paymentKey): PaymentResult;
}
