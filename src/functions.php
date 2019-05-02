<?php

use Orkhanahmadov\Goldenpay\Goldenpay;

if (!function_exists('goldenpay')) {
    /**
     * Global helper function.
     *
     * @param string|null $authKey
     * @param string|null $merchantName
     *
     * @return Goldenpay
     */
    function goldenpay(string $authKey = null, string $merchantName = null)
    {
        if ($authKey && $merchantName) {
            return new Goldenpay($authKey, $merchantName);
        }

        return new Goldenpay(config('goldenpay.auth_key'), config('goldenpay.merchant_name'));
    }
}
