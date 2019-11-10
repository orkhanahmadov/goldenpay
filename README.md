# :credit_card: [GoldenPay](http://www.goldenpay.az) library for PHP

[![Latest Stable Version](https://poser.pugx.org/orkhanahmadov/goldenpay/v/stable)](https://packagist.org/packages/orkhanahmadov/goldenpay)
[![Latest Unstable Version](https://poser.pugx.org/orkhanahmadov/goldenpay/v/unstable)](https://packagist.org/packages/orkhanahmadov/goldenpay)
[![Total Downloads](https://img.shields.io/packagist/dt/orkhanahmadov/goldenpay)](https://packagist.org/packages/orkhanahmadov/goldenpay)
[![GitHub license](https://img.shields.io/github/license/orkhanahmadov/goldenpay.svg)](https://github.com/orkhanahmadov/goldenpay/blob/master/LICENSE.md)

[![Build Status](https://img.shields.io/travis/orkhanahmadov/goldenpay.svg)](https://travis-ci.org/orkhanahmadov/goldenpay)
[![Test Coverage](https://api.codeclimate.com/v1/badges/92b05e08792d8c204cf6/test_coverage)](https://codeclimate.com/github/orkhanahmadov/goldenpay/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/92b05e08792d8c204cf6/maintainability)](https://codeclimate.com/github/orkhanahmadov/goldenpay/maintainability)
[![Quality Score](https://img.shields.io/scrutinizer/g/orkhanahmadov/goldenpay.svg)](https://scrutinizer-ci.com/g/orkhanahmadov/goldenpay)
[![StyleCI](https://github.styleci.io/repos/184265600/shield?branch=master)](https://github.styleci.io/repos/184265600)

## Requirements

**PHP 7.2** or higher, with ``json`` extension.

## Installation

```bash
composer require orkhanahmadov/goldenpay
```

## Usage

First, instantiate ``Orkhanahmadov\Goldenpay\Goldenpay`` with "auth key" and "merchant name". Both can be acquired from [Goldenpay merchant dashboard](https://rest.goldenpay.az/merchant/).

```php
use Orkhanahmadov\Goldenpay\Goldenpay;

$goldenpay = new Goldenpay('auth-key-here', 'merchant-name-here');
```

### Getting payment key
To get new payment key use ``newPaymentKey`` method.

Method accepts following arguments:
* **Amount** - Amount to charge. Only integer accepted. For example 10.25 needs to be converted to 1025
* **Card type** - Use 'v' for VISA, 'm' for MasterCard
* **Description** - Payment related description
* **Language** *(optional)* - Sets payment page interface language. 'en' for english, 'ru' for russian, 'lv' for azerbaijani. Default is 'lv'

```php
$paymentKey = $goldenpay->newPaymentKey(100, 'v', 'your-description', 'en');
```

Method will return instance of ``Orkhanahmadov\Goldenpay\PaymentKey``. You can access payment key and payment url from this object instance.

```php
$paymentKey->code; // endpoint response code
$paymentKey->message; // endpoint response message
$paymentKey->paymentKey; // unique payment key
$paymentKey->paymentUrl(); // payment url. you can redirect user to this url to start payment
```

**Important!** Goldenpay charges all payments only in AZN.

### Checking payment result
To check payment result use ``checkPaymentResult`` method.

Method accepts following arguments:
* **Payment key** - Previously available payment key

```php
$paymentResult = $goldenpay->checkPaymentResult('payment-key-here');
```

Method will return instance of ``Orkhanahmadov\Goldenpay\PaymentResult``. You can access following properties from this object instance:

```php
$paymentResult->paymentKey; // Orkhanahmadov\Goldenpay\PaymentKey instance
$paymentResult->merchantName; // merchant name
$paymentResult->amount; // charged amount in integer. 100 = 1.00
$paymentResult->checkCount; // shows how many times this payment key result checked
$paymentResult->paymentDate; // payment date in Y-m-d H:m:i format. Example: 2019-04-30 14:16:58
$paymentResult->cardNumber; // charged card number. only first 6 digits and last 4 digits. Example: 422865******8101
$paymentResult->language; // 2 letter interface language: 'lv', 'en' or 'ru'
$paymentResult->description; // description used for payment
$paymentResult->rrn; // payment reference number
```

You can also use helper function:

```php
goldenpay('auth-key-here', 'merchant-name-here')->newPaymentKey(100, 'v', 'your-description', 'en');
goldenpay('auth-key-here', 'merchant-name-here')->checkPaymentResult('payment-key-here');
```

``Orkhanahmadov\Goldenpay\Goldenpay`` implements ``Orkhanahmadov\Goldenpay\GoldenpayInterface``. You can use this interface as abstraction for dependency injection.

## Testing

``` bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email ahmadov90@gmail.com instead of using the issue tracker.

## Credits

- [Orkhan Ahmadov](https://github.com/orkhanahmadov)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
