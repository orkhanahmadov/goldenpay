<?php

namespace Orkhanahmadov\Goldenpay\Enums;

use MyCLabs\Enum\Enum;

/**
 * @method static self VISA()
 * @method static self MASTERCARD()
 */
class CardType extends Enum
{
    private const VISA = 'v';
    private const MASTERCARD = 'm';
}
