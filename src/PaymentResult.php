<?php

namespace Orkhanahmadov\Goldenpay;

class PaymentResult
{
    /**
     * @var PaymentKey
     */
    private $paymentKey;
    /**
     * @var string
     */
    private $merchantName;
    /**
     * @var int
     */
    private $amount;
    /**
     * @var int
     */
    private $checkCount;
    /**
     * @var \DateTimeImmutable
     */
    private $paymentDate;
    /**
     * @var string
     */
    private $cardNumber;
    /**
     * @var string
     */
    private $language;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $rrn;

    /**
     * PaymentResult constructor.
     *
     * @param array $paymentResult
     */
    public function __construct(array $paymentResult)
    {
        $this->paymentKey = new PaymentKey(
            $paymentResult['status']['code'],
            $paymentResult['status']['message'],
            $paymentResult['paymentKey']
        );
        $this->merchantName = $paymentResult['merchantName'];
        $this->amount = $paymentResult['amount'];
        $this->checkCount = $paymentResult['checkCount'];
        $this->paymentDate = new \DateTimeImmutable($paymentResult['paymentDate']);
        $this->cardNumber = $paymentResult['cardNumber'];
        $this->language = $paymentResult['language'];
        $this->description = $paymentResult['description'];
        $this->rrn = $paymentResult['rrn'];
    }

    /**
     * @return PaymentKey
     */
    public function getPaymentKey(): PaymentKey
    {
        return $this->paymentKey;
    }

    /**
     * @return string
     */
    public function getMerchantName(): string
    {
        return $this->merchantName;
    }

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

    /**
     * @return int
     */
    public function getCheckCount(): int
    {
        return $this->checkCount;
    }

    /**
     * @return \DateTimeImmutable
     */
    public function getPaymentDate(): \DateTimeImmutable
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getCardNumber(): string
    {
        return $this->cardNumber;
    }

    /**
     * @return string
     */
    public function getLanguage(): string
    {
        return $this->language;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getRrn(): string
    {
        return $this->rrn;
    }
}
