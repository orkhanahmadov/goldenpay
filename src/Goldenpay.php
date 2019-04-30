<?php

namespace Orkhanahmadov\Goldenpay;

use GuzzleHttp\Client;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;
use Orkhanahmadov\Goldenpay\Payment\Key;
use Orkhanahmadov\Goldenpay\Payment\Result;

class Goldenpay
{
    /**
     * @var string
     */
    private $authKey;
    /**
     * @var string
     */
    private $merchantName;
    /**
     * @var Client
     */
    private $client;

    /**
     * Goldenpay constructor.
     * @param string|null $authKey
     * @param string|null $merchantName
     * @param Client|null $client
     */
    public function __construct(string $authKey = null, string $merchantName = null, Client $client = null)
    {
        $this->authKey = $authKey ?: config('goldenpay.auth_key');
        $this->merchantName = $merchantName ?: config('goldenpay.merchant_name');
        $this->client = $client ?: new Client;
    }

    /**
     * @param int $amount
     * @param string $cardType
     * @param string $description
     * @param string $lang
     * @return Key
     */
    public function newPaymentKey(int $amount, string $cardType, string $description, string $lang = 'lv')
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey', [
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'merchantName' => $this->merchantName,
                'amount' => $amount,
                'cardType' => $cardType,
                'description' => $description,
                'lang' => $lang === 'az' ? 'lv' : $lang,
                'hashCode' => md5($this->authKey . $this->merchantName . $cardType . $amount . $description),
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['status']['code'] !== 1)
            throw new GoldenpayPaymentKeyException($result['status']['message']);

        return new Key($result['status']['code'], $result['status']['message'], $result['paymentKey']);
    }

    /**
     * @param string $paymentKey
     * @return Result
     */
    public function checkPaymentResult(string $paymentKey)
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentResult', [
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'payment_key' => $paymentKey,
                'Hash_code' => md5($this->authKey . $paymentKey)
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new Result($result);
    }
}
