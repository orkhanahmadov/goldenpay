<?php

namespace Orkhanahmadov\Goldenpay\Response;

class PaymentResult extends Status
{
    /**
     * @var string
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
     * @var \DateTimeImmutable|null
     */
    private $paymentDate = null;
    /**
     * @var string|null
     */
    private $cardNumber = null;
    /**
     * @var string
     */
    private $language;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string|null
     */
    private $referenceNumber = null;

    /**
     * PaymentResult constructor.
     *
     * @param array $paymentResult
     */
    public function __construct(array $paymentResult)
    {
        $this->code = $paymentResult['status']['code'];
        $this->message = $paymentResult['status']['message'];
        $this->paymentKey = $paymentResult['paymentKey'];
        $this->merchantName = $paymentResult['merchantName'];
        $this->amount = $paymentResult['amount'];
        $this->checkCount = $paymentResult['checkCount'];
        $this->cardNumber = $paymentResult['cardNumber'];
        $this->language = $paymentResult['language'];
        $this->description = $paymentResult['description'];
        $this->referenceNumber = $paymentResult['rrn'];

        if ($paymentResult['paymentDate']) {
            $this->paymentDate = new \DateTimeImmutable($paymentResult['paymentDate']);
        }
    }

    /**
     * @return string
     */
    public function getPaymentKey(): string
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
     * @return \DateTimeImmutable|null
     */
    public function getPaymentDate(): ?\DateTimeImmutable
    {
        return $this->paymentDate;
    }

    /**
     * @return string|null
     */
    public function getCardNumber(): ?string
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
     * @return string|null
     */
    public function getReferenceNumber(): ?string
    {
        return $this->referenceNumber;
    }
}
