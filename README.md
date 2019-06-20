# Tigopesa (Tz) Push API - Laravel Package

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Travis](https://img.shields.io/travis/tumainimosha/laravel-tigopesa-push.svg?style=flat-square)]()
[![Total Downloads](https://img.shields.io/packagist/dt/tumainimosha/laravel-tigopesa-push.svg?style=flat-square)](https://packagist.org/packages/tumainimosha/laravel-tigopesa-push)

## Install
`composer require tumainimosha/laravel-tigopesa-push`

### Publish Configuration File

Publish config file to customize the default package config.

```bash
php artisan vendor:publish --provider="Tumainimosha\TigopesaPush\TigopesaPushServiceProvider" --tag="config"
```

## Configuration

### Authentication

Configure your api username and password in `.env` file as follows

```dotenv
TZ_TIGOPESA_PUSH_USERNAME=123123
TZ_TIGOPESA_PUSH_PASSWORD=VeryStrongPasswd
TZ_TIGOPESA_PUSH_BUSINESS_MSISDN=FooCompany

Other configuration can be found in the config file published by this package. The options are well commented :)

## Usage
@TODO

## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security
If you discover any security-related issues, please email  instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
