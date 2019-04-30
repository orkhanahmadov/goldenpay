## :credit_card: [GoldenPay](http://www.goldenpay.az) library for PHP and Laravel framework

[![Build Status](https://travis-ci.org/orkhanahmadov/goldenpay.svg?branch=master)](https://travis-ci.org/orkhanahmadov/goldenpay)
[![Test Coverage](https://api.codeclimate.com/v1/badges/92b05e08792d8c204cf6/test_coverage)](https://codeclimate.com/github/orkhanahmadov/goldenpay/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/92b05e08792d8c204cf6/maintainability)](https://codeclimate.com/github/orkhanahmadov/goldenpay/maintainability)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/orkhanahmadov/goldenpay/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/orkhanahmadov/goldenpay/?branch=master)
[![StyleCI](https://github.styleci.io/repos/184265600/shield?branch=master)](https://github.styleci.io/repos/184265600)

### Installation

``composer require orkhanahmadov/goldenpay``

### General usage

First, instantiate ``Orkhanahmadov\Goldenpay\GoldenpayService`` with "auth key" and "merchant name". Both can be acquired from [Goldenpay merchant dashboard](https://rest.goldenpay.az/merchant/).

```php
use Orkhanahmadov\Goldenpay\GoldenpayService;

$goldenpay = new GoldenpayService('auth-key-here', 'merchant-name-here');
```

#### Getting payment key
To get new payment key use ``newPaymentKey`` method.

Method accepts following arguments:
* **Amount** - Amount to charge. No decimals, only integer accepted. For example 10.25 needs to be converted to 1025
* **Card type** - Use 'v' for VISA, 'm' for MasterCard
* **Description** - Payment related description
* **Language** *(optional)* - Sets payment page interface language. 'en' for azerbaijani, 'ru' for russian, 'lv' for azerbaijani. Default is 'lv'

```php
$paymentKey = $goldenpay->newPaymentKey(100, 'v', 'description', 'lv');
```

Method will return instance of ``Orkhanahmadov\Goldenpay\PaymentKey``. You can access payment key and payment url from this object instance.

```php
$paymentKey->paymentKey; // fetched payment key
$paymentKey->paymentUrl(); // full payment url
```

#### Checking payment result
To check payment result use ``checkPaymentResult`` method.

Method accepts following arguments:
* **Payment key** - Payment key previously fetched with ``newPaymentKey`` method.

```php
$paymentResult = $goldenpay->checkPaymentResult('payment-key-here');
```

Method will return instance of ``Orkhanahmadov\Goldenpay\PaymentResult``. You can access following properties from this object instance:

```php
$paymentResult->paymentKey; // Orkhanahmadov\Goldenpay\PaymentKey instance with payment key and payment url
$paymentResult->merchantName; // merchant name
$paymentResult->amount; // charged amount in integer. 100 = 1.00
$paymentResult->checkCount; // shows how many times this payment key result checked
$paymentResult->paymentDate; // payment date in Y-m-d H:m:i format. Example: 2019-04-30 14:16:58
$paymentResult->cardNumber; // charged card number. only first 6 digits and last 4 digits. Example: 422865******8101
$paymentResult->language; // 2 letter interface language
$paymentResult->description; // payment description
$paymentResult->rrn; // payment reference number
```

### Laravel usage

Set ``GOLDENPAY_AUTH_KEY`` and ``GOLDENPAY_MERCHANT_NAME`` variables in ``.env`` file:

```bash
GOLDENPAY_AUTH_KEY=your_auth_key
GOLDENPAY_MERCHANT_NAME=your_merchant_name
```

To publish package config files, run:

```bash
php artisan vendor:publish --provider="Orkhanahmadov\Goldenpay\Laravel\ServiceProvider"
```

You can use Laravel helper method to get new payment key or check payment result:

```php
goldenpay()->newPaymentKey(100, 'v', 'description', 'lv');
goldenpay()->checkPaymentResult('payment-key-here');
```

### License
MIT

### Contributions
PRs are welcome :blush:
