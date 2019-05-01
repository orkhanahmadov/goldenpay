<?php

namespace Orkhanahmadov\Goldenpay;

use GuzzleHttp\Client;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;

class Goldenpay
{
    /**
     * @var string|null
     */
    public $authKey;
    /**
     * @var string|null
     */
    public $merchantName;
    /**
     * @var Client
     */
    private $client;

    /**
     * Goldenpay constructor.
     *
     * @param string $authKey
     * @param string $merchantName
     */
    public function __construct($authKey, $merchantName)
    {
        $this->authKey = $authKey;
        $this->merchantName = $merchantName;
        $this->client = new Client();
    }

    /**
     * Gets new payment key.
     *
     * @param int    $amount
     * @param string $cardType
     * @param string $description
     * @param string $lang
     *
     * @throws GoldenpayPaymentKeyException
     *
     * @return PaymentKey
     */
    public function newPaymentKey(int $amount, string $cardType, string $description, string $lang = 'lv')
    {
        $result = $this->sendRequest('https://rest.goldenpay.az/web/service/merchant/getPaymentKey', [
            'merchantName' => $this->merchantName,
            'amount'       => $amount,
            'cardType'     => $cardType,
            'description'  => $description,
            'lang'         => $lang,
            'hashCode'     => md5($this->authKey.$this->merchantName.$cardType.$amount.$description),
        ]);

        if ($result['status']['code'] !== 1) {
            throw new GoldenpayPaymentKeyException($result['status']['message'].'. Code: '.$result['status']['code']);
        }

        return new PaymentKey($result['status']['code'], $result['status']['message'], $result['paymentKey']);
    }

    /**
     * Checks payment result.
     *
     * @param string $paymentKey
     *
     * @return PaymentResult
     */
    public function checkPaymentResult(string $paymentKey)
    {
        $result = $this->sendRequest('https://rest.goldenpay.az/web/service/merchant/getPaymentResult', [
            'payment_key' => $paymentKey,
            'Hash_code'   => md5($this->authKey.$paymentKey),
        ]);

        return new PaymentResult($result);
    }

    /**
     * Sends requests to GoldenPay endpoint.
     *
     * @param string $url
     * @param array  $json
     *
     * @return array
     */
    private function sendRequest(string $url, array $json)
    {
        $response = $this->client->post($url, [
            'headers' => ['Accept' => 'application/json'],
            'json'    => $json,
        ]);

        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}
