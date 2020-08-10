# :credit_card: [GoldenPay](http://www.goldenpay.az) library for PHP

#### If you are using Laravel, you can use [`laravel-goldenpay`](https://github.com/orkhanahmadov/laravel-goldenpay) package instead for better integration with more features.

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

First, instantiate ``Orkhanahmadov\Goldenpay\Goldenpay`` and call ``authenticate()`` method with "auth key" and "merchant name". Both can be acquired from [Goldenpay merchant dashboard](https://rest.goldenpay.az/merchant/).

```php
use Orkhanahmadov\Goldenpay\Goldenpay;

$goldenpay = new Goldenpay();
$goldenpay->authenticate('auth-key-here', 'merchant-name-here');
```

### Getting payment key
To get new payment key use ``payment`` method.

Method accepts following arguments:
* **Amount** - Amount to charge. Only integer accepted. For example 10.25 needs to be converted to 1025
* **Card type** - Requires instance of `Orkhanahmadov\Goldenpay\Enums\CardType`.
`CardType::VISA()` for VISA, `CardType::MASTERCARD()` for MasterCard
* **Description** - Payment related description
* **Language** *(optional)* - Sets payment page interface language. Requires instance of `Orkhanahmadov\Goldenpay\Enums\Language`.
`Language::EN()` for english, `Language::RU()` for russian, `Language::AZ()` for azerbaijani. Default is azerbaijani

```php
$paymentKey = $goldenpay->payment(100, CardType::VISA(), 'item-description', Language::EN());
```

Method will return instance of ``Orkhanahmadov\Goldenpay\Response\PaymentKey``. You can access payment key and payment url from this object instance.

```php
$paymentKey->getCode(); // endpoint response code
$paymentKey->getMessage(); // endpoint response message
$paymentKey->getPaymentKey(); // unique payment key
$paymentKey->paymentUrl(); // payment url. you should redirect user to this url to start payment
```

**Important!** Goldenpay charges all payments only in AZN.

### Checking payment result
To check payment result use ``result`` method.

Method accepts following arguments:
* **Payment key** - Previously available payment key

```php
$paymentResult = $goldenpay->result('payment-key-here');
```

Method also accepts instance of ``Orkhanahmadov\Goldenpay\Response\PaymentKey`` as an argument.

Method will return instance of ``Orkhanahmadov\Goldenpay\Response\PaymentResult``. You can access following properties from this object instance:

```php
$paymentResult->getCode(); // status code
$paymentResult->getMessage(); // status message
$paymentResult->getPaymentKey(); // instance of Orkhanahmadov\Goldenpay\Response\PaymentKey
$paymentResult->getMerchantName(); // merchant name
$paymentResult->getAmount(); // charged amount in integer format. 100 = 1.00
$paymentResult->getCheckCount(); // shows how many times this payment key result checked
$paymentResult->getPaymentDate(); // \DateTimeImmutable instance of payment date
$paymentResult->getCardNumber(); // charged card number. only first 6 digits and last 4 digits. Example: 422865******8101
$paymentResult->getLanguage(); // 2 letter interface language: 'lv', 'en' or 'ru'
$paymentResult->getDescription(); // description used for payment
$paymentResult->getReferenceNumber(); // payment reference number
```

You can also use global helper function. Calling this function requires passing "auth key" and "merchant name".

```php
$goldenpay = goldenpay('auth-key-here', 'merchant-name-here'); // returns instance of "Orkhanahmadov\Goldenpay\Goldenpay"
$goldenpay->payment(100, CardType::VISA(), 'your-description', Language::EN());
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
