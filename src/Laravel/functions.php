<?php

use Orkhanahmadov\Goldenpay\GoldenpayService;

if (! function_exists('goldenpay')) {
    /**
     * Helper method for Laravel.
     *
     * @param string|null $authKey
     * @param string|null $merchantName
     * @return GoldenpayService
     */
    function goldenpay(string $authKey = null, string $merchantName = null)
    {
        if ($authKey && $merchantName) {
            return new GoldenpayService($authKey, $merchantName);
        }

        return new GoldenpayService(config('goldenpay.auth_key'), config('goldenpay.merchant_name'));
    }
}
