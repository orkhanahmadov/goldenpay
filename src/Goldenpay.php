<?php

namespace Orkhanahmadov\Goldenpay;

use GuzzleHttp\Client;
use Orkhanahmadov\Goldenpay\Exceptions\GoldenpayPaymentKeyException;

class Goldenpay
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Goldenpay constructor.
     *
     * @param Client|null $client
     */
    public function __construct(Client $client = null)
    {
        $this->client = $client ?: new Client;
    }

    /**
     * Get new payment key from Goldenpay endpoint
     *
     * @param string $authKey
     * @param string $merchantName
     * @param int $amount
     * @param string $cardType
     * @param string $description
     * @param string $lang
     * @return PaymentKey
     */
    public function newPaymentKey(string $authKey, string $merchantName, int $amount, string $cardType, string $description, string $lang = 'lv')
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentKey', [
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'merchantName' => $merchantName,
                'amount' => $amount,
                'cardType' => $cardType,
                'description' => $description,
                'lang' => $lang,
                'hashCode' => md5($authKey . $merchantName . $cardType . $amount . $description),
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        if ($result['status']['code'] !== 1)
            throw new GoldenpayPaymentKeyException($result['status']['message']);

        return new PaymentKey($result['status']['code'], $result['status']['message'], $result['paymentKey']);
    }

    /**
     * Checks result from Goldenpay endpoint
     *
     * @param string $authKey
     * @param string $paymentKey
     * @return PaymentResult
     */
    public function checkPaymentResult(string $authKey, string $paymentKey)
    {
        $response = $this->client->post('https://rest.goldenpay.az/web/service/merchant/getPaymentResult', [
            'headers' => ['Accept' => 'application/json'],
            'json' => [
                'payment_key' => $paymentKey,
                'Hash_code' => md5($authKey . $paymentKey)
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return new PaymentResult($result);
    }
}
