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

### Run migration

```bash
php artisan migrate
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

### Quick start

```php
use Tumainimosha\TigopesaPush\TigopesaPush;

$customerMsisdn = '255652111222';
$amount = 1000;
$txnId = uniqid();

$tigopesaPushService = TigopesaPush::instance();
$response = $tigopesaPushService->postRequest($customerMsisdn, $amount, $txnId);

/** @var bool $success */
$success = $response['ResponseStatus'];
```

### Handling callback

Out of the box, this package stores transactions in table `tigopesa_push_transactions`, and updates their status on receiving callback.

However, you may need to do further actions on your app after receiving callback, by listening to event `TigopesaCallbackReceivedHandler::class` fired at callback.

You need to implement your own event listener to listen for this event and do any additional steps after receiving callback.

The event has public attribute `$transaction` which contains the transaction parameters including status

```php
// EventServiceProvider.php

protected $listen = [
    ...
    \Tumainimosha\TigopesaPush\Events\TigopesaCallbackReceived::class => [
        \App\Listeners\TigopesaCallbackReceivedHandler::class,
    ],
];

// TigopesaCallbackReceivedHandler.php

public function handle(TigopesaCallbackReceived $event)
{
    $transaction = $event->transaction;
    
    // do your custom logic here
}

```
### Customize config values at runtime

The service offers fluent setters to change config values at runtime if your use case requires.

Such a use case could be when you have multiple accounts on the same project, and you fetch your config values from DB.

```php
$tigopesaPushService = TigopesaPush::instance();

$tigopesaPushService->setUsername($account->username)
    ->setPassword($account->password)
    ->setBillerMsisdn($account->business_number)
    ->setTokenUrl(config('tigopesa-push.token_url'))
    ->setBillPayUrl(config('tigopesa-push.bill_pay_url'));
```
## Testing
Run the tests with:

``` bash
vendor/bin/phpunit
```

## Contributing
Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

** Help needed with improving documentation and unit testing. Pull Requests are welcome.

## Security
If you discover any security-related issues, please email instead of using the issue tracker.

## License
The MIT License (MIT). Please see [License File](/LICENSE.md) for more information.
