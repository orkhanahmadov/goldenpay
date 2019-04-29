<?php

namespace Orkhanahmadov\Goldenpay;

use GuzzleHttp\Client;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;
use Orkhanahmadov\Goldenpay\Payment\Key;
use Orkhanahmadov\Goldenpay\Payment\Result;

class Goldenpay
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Goldenpay constructor.
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $authKey
     * @param string $merchantName
     * @param string $cardType
     * @param int $amount
     * @param string $description
     * @param string $lang
     * @return Key
     */
    public function newPaymentKey(string $authKey, string $merchantName, string $cardType, int $amount, string $description, string $lang = 'lv')
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => [
                'merchantName' => $merchantName,
                'amount' => $amount,
                'cardType' => $cardType,
                'description' => $description,
                'lang' => $lang === 'az' ? 'lv' : $lang,
                'hashCode' => md5($authKey . $merchantName . $cardType . $amount . $description),
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['status']['code'] !== 1)
            throw new GoldenpayPaymentKeyException($result['status']['message']);

        return new Key($result['status']['code'], $result['status']['message'], $result['paymentKey']);
    }

    /**
     * @param string $authKey
     * @param string $paymentKey
     * @return Result
     */
    public function checkPaymentResult(string $authKey, string $paymentKey)
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentResult', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'json' => [
                'payment_key' => $paymentKey,
                'Hash_code' => md5($authKey . $paymentKey)
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new Result($result);
    }
}
