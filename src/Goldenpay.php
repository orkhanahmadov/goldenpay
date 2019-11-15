<?php

namespace Orkhanahmadov\Goldenpay;

use GuzzleHttp\Client;
use function GuzzleHttp\json_decode;
use Orkhanahmadov\Goldenpay\Enums\CardType;
use Orkhanahmadov\Goldenpay\Enums\Language;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;
use Orkhanahmadov\Goldenpay\Response\PaymentKey;
use Orkhanahmadov\Goldenpay\Response\PaymentResult;

class Goldenpay implements PaymentInterface
{
    /**
     * @var string|null
     */
    private $authKey = null;
    /**
     * @var string|null
     */
    private $merchantName = null;
    /**
     * @var Client
     */
    private $client;

    /**
     * Goldenpay constructor.
     */
    public function __construct()
    {
        $this->client = new Client(['base_uri' => 'https://rest.goldenpay.az/web/service/merchant/']);
    }

    /**
     * Sets Goldenpay authentication credentials.
     *
     * @param string $authKey
     * @param string $merchantName
     *
     * @return self
     */
    public function authenticate(string $authKey, string $merchantName): PaymentInterface
    {
        $this->authKey = $authKey;
        $this->merchantName = $merchantName;

        return $this;
    }

    /**
     * Gets new payment key from Goldenpay.
     *
     * @param int           $amount
     * @param CardType      $cardType
     * @param string        $description
     * @param Language|null $lang
     *
     * @throws GoldenpayPaymentKeyException
     *
     * @return PaymentKey
     */
    public function payment(int $amount, CardType $cardType, string $description, ?Language $lang = null): PaymentKey
    {
        $result = $this->request('getPaymentKey', [
            'merchantName' => $this->merchantName,
            'amount'       => $amount,
            'cardType'     => $cardType->getValue(),
            'description'  => $description,
            'lang'         => $lang ? $lang->getValue() : 'lv',
            'hashCode'     => md5($this->authKey.$this->merchantName.$cardType->getValue().$amount.$description),
        ]);

        if ($result['status']['code'] !== 1) {
            throw new GoldenpayPaymentKeyException($result['status']['message'].'. Code: '.$result['status']['code']);
        }

        return new PaymentKey(
            $result['paymentKey'],
            $result['status']['code'],
            $result['status']['message']
        );
    }

    /**
     * Checks result of payment using existing payment key.
     *
     * @param PaymentKey|string $paymentKey
     *
     * @return PaymentResult
     */
    public function result($paymentKey): PaymentResult
    {
        $paymentKey = $paymentKey instanceof PaymentKey ? $paymentKey->getPaymentKey() : $paymentKey;

        $result = $this->request('getPaymentResult', [
            'payment_key' => $paymentKey,
            'hash_code'   => md5($this->authKey.$paymentKey),
        ]);

        return new PaymentResult(
            $result,
            $result['status']['code'],
            $result['status']['message']
        );
    }

    /**
     * Sends requests to GoldenPay endpoint.
     *
     * @param string $endpoint
     * @param array  $data
     *
     * @return array
     */
    private function request(string $endpoint, array $data)
    {
        if ($endpoint === 'getPaymentResult') {
            $response = $this->client->get($endpoint, [
                'headers' => ['Accept' => 'application/json'],
                'query'   => $data,
            ]);
        } else {
            $response = $this->client->post($endpoint, [
                'headers' => ['Accept' => 'application/json', 'Content-Type' => 'application/json'],
                'json'    => $data,
            ]);
        }

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @return string|null
     */
    public function getAuthKey(): ?string
    {
        return $this->authKey;
    }

    /**
     * @return string|null
     */
    public function getMerchantName(): ?string
    {
        return $this->merchantName;
    }
}
