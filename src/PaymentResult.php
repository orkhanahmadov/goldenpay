<?php

namespace Orkhanahmadov\Goldenpay;

class PaymentResult
{
    /**
     * @var PaymentKey
     */
    public $paymentKey;
    /**
     * @var string
     */
    public $merchantName;
    /**
     * @var int
     */
    public $amount;
    /**
     * @var int
     */
    public $checkCount;
    /**
     * @var string
     */
    public $paymentDate;
    /**
     * @var string
     */
    public $cardNumber;
    /**
     * @var string
     */
    public $language;
    /**
     * @var string
     */
    public $description;
    /**
     * @var string
     */
    public $rrn;

    /**
     * PaymentResult constructor.
     * @param array $paymentResult
     */
    public function __construct(array $paymentResult)
    {
        $this->paymentKey = new PaymentKey($paymentResult['status']['code'], $paymentResult['status']['message'], $paymentResult['paymentKey']);
        $this->merchantName = $paymentResult['merchantName'];
        $this->amount = $paymentResult['amount'];
        $this->checkCount = $paymentResult['checkCount'];
        $this->paymentDate = $paymentResult['paymentDate'];
        $this->cardNumber = $paymentResult['cardNumber'];
        $this->language = $paymentResult['language'];
        $this->description = $paymentResult['description'];
        $this->rrn = $paymentResult['rrn'];
    }
}
