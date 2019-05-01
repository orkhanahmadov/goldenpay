<?php

namespace Orkhanahmadov\Goldenpay\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class Goldenpay extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Goldenpay';
    }
}
