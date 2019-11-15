<?php

namespace Orkhanahmadov\Goldenpay\Response;

class PaymentResult extends Response
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
     * @param array  $data
     * @param int    $code
     * @param string $message
     */
    public function __construct(array $data, int $code, string $message)
    {
        parent::__construct($code, $message);

        $this->paymentKey = new PaymentKey($data['paymentKey']);
        $this->merchantName = $data['merchantName'];
        $this->amount = $data['amount'];
        $this->checkCount = $data['checkCount'];
        $this->cardNumber = $data['cardNumber'];
        $this->language = $data['language'];
        $this->description = $data['description'];
        $this->referenceNumber = $data['rrn'];

        if ($data['paymentDate']) {
            $this->paymentDate = new \DateTimeImmutable($data['paymentDate']);
        }
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
