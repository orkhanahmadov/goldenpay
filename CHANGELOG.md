## Changelog

All notable changes to `goldenpay` will be documented in this file

### 2.1.0 - 2020-01-10
- PHP 7.4 support
- PSR-12 code-style changes

### 2.0.0 - 2019-11-15
- Library completely rewritten
- Laravel related functionality removed.
Use [laravel-goldenpay](https://github.com/orkhanahmadov/laravel-goldenpay) package for full-feature Laravel integration.
- PHP 7.1 support removed due to EOL.

### 1.3.0 - 2019-11-13
- `checkPaymentResult()` method request fixed

### 1.2.0 - 2019-07-30
- Dependency requirements lowered

### 1.1.0
- GoldenpayInterface added for better dependency abstraction

### 1.0.4
- Changed global function load directory

### 1.0.3
- DI change within Goldenpay service

### 1.0.2
- GoldenpayPaymentKeyException now shows endpoint error code

### 1.0.1
- Fixed Laravel service provider bug

### 1.0.0
- Initial release
