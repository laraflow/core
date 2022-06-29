# Laraflow Core

[![Latest Version on Packagist](https://img.shields.io/packagist/v/laraflow/core.svg?style=flat-square)](https://packagist.org/packages/laraflow/core)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/laraflow/core/run-tests?label=tests)](https://github.com/laraflow/core/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/laraflow/core/Check%20&%20fix%20styling?label=code%20style)](https://github.com/laraflow/core/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/laraflow/core.svg?style=flat-square)](https://packagist.org/packages/laraflow/core)

set of wrapper class for laraflow apps

## Installation

You can install the package via composer:

```bash
composer require laraflow/core
```

You can publish and run the migrations with:

```bash
php artisan vendor:publish --tag="laraflow-migrations"
php artisan migrate
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laraflow-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laraflow-views"
```

## Usage

```php
$laraflow = new Laraflow\Core();
echo $laraflow->echoPhrase('Hello, Laraflow!');
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mohammad Hafijul Islam](https://github.com/laraflow)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
