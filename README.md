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

Configure your api parameters in `.env` file as follows. Substitute example values below with those provided to you at time of integration.

```dotenv
TZ_TIGOPESA_PUSH_USERNAME=<your-username>
TZ_TIGOPESA_PUSH_PASSWORD=<your-password>
TZ_TIGOPESA_PUSH_BILLER_MSISDN=<your-biller-msisdn> # Should start with country code 255 followed by 9 digits. eg: 25565000111
TZ_TIGOPESA_PUSH_GET_TOKEN_URL=<your-get-token-url>
TZ_TIGOPESA_PUSH_BILL_PAY_URL=<your-biller-pay-url>
```

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
If you discover any security-related issues, please email instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
