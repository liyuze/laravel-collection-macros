# A set of useful Laravel collection macros

[![Latest Version on Packagist](https://img.shields.io/packagist/v/liyuze/laravel-collection-macros.svg?style=flat-square)](https://packagist.org/packages/liyuze/laravel-collection-macros)
[![Total Downloads](https://img.shields.io/packagist/dt/liyuze/laravel-collection-macros.svg?style=flat-square)](https://packagist.org/packages/liyuze/laravel-collection-macros)
![GitHub Actions](https://github.com/liyuze/laravel-collection-macros/actions/workflows/main.yml/badge.svg)

This repository contains some useful collection macros.

## Installation

You can install the package via composer:

```bash
composer require liyuze/laravel-collection-macros
```

## Macros

- if flow call
    - [`ifThen`](#ifThen)
    - [`unlessThen`](#unlessThen)
    - IfHigherOrderCollectionProxy
        - [`else`](#else)
        - [`after`](#after)
        - [`value`](#value)

## Usage

### ifThen

```php
collect([1,2,3])->ifThen(true)->map(fn($v)=>$v*2)->value()->min();
// 2
collect([1,2,3])->ifThen(false)->map(fn($v)=>$v*2)->value()->min();
// 1
collect([1,2,3])->ifThen(0)->min()->else()->max()->after(fn($v,$c)=>$v*$c->count())->value();
// 9
```

### unlessThen

```php
collect([1,2,3])->unlessThen(false)->sortDesc()->value()->first();
// 3
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email 290315384@qq.com instead of using the issue tracker.

## Credits

- [liyuze](https://github.com/liyuze)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
