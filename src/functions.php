<?php

use Orkhanahmadov\Goldenpay\Goldenpay;

if (!function_exists('goldenpay')) {
    /**
     * Global helper function.
     *
     * @param string $authKey
     * @param string $merchantName
     *
     * @return Goldenpay
     */
    function goldenpay(string $authKey, string $merchantName)
    {
        return (new Goldenpay())->authenticate($authKey, $merchantName);
    }
}
