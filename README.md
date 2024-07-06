# Beacon

[![Latest Version on Packagist](https://img.shields.io/packagist/v/executable/laravel-livewire-beacon.svg?style=flat-square)](https://packagist.org/packages/executable/laravel-livewire-beacon)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/executable/laravel-livewire-beacon/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/drjamesj/laravel-livewire-beacon/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/executable/laravel-livewire-beacon/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/drjamesj/laravel-livewire-beacon/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/executable/laravel-livewire-beacon.svg?style=flat-square)](https://packagist.org/packages/executable/laravel-livewire-beacon)

Beacon enables websocket communication for Livewire dramatically improving user experience and enabling more features.

## Requirements

This package provides a thin layer that sits on top of [Laravel Livewire](https://livewire.laravel.com/) and [Laravel Reverb](https://reverb.laravel.com/) as the core requirements.

-   Laravel Livewire installed ([docs](https://livewire.laravel.com/docs/installation))
-   Laravel Reverb installed ([docs](https://laravel.com/docs/11.x/reverb))
-   Laravel Echo installed and served on frontend ([docs](https://laravel.com/docs/11.x/broadcasting#client-side-installation))

## Installation

You can install the package via composer:

```bash
composer require executable/laravel-livewire-beacon
```

Next, edit your app's layout to include the Beacon javascript assets. This is best done by adding the Blade directive `@livewireBeaconScripts` just before the closing `body` tag.

```
<!-- resources/views/layouts/app.blade.php -->

    @livewireBeaconScripts
</body>

</html>
```

## Configuration

Beacon is designed to work seamlessly without further configuration.

If you'd like to modify some internal behaviour of this package, you can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-livewire-beacon-config"
```

## Usage

That's it! Continue using Livewire as you would normally, and enjoy significant performance improvements.

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

-   [James Joffe](https://github.com/drjamesj)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
