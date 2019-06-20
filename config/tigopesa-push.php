<?php

return [

    /**
     * User name provided for the merchant.
     */
    'username' => env('TZ_TIGOPESA_PUSH_USERNAME'),

    /**
     * Password provided for the merchant.
     */
    'password' => env('TZ_TIGOPESA_PUSH_PASSWORD'),

    /**
     * Phone number of the biller. It should start with 255
     * country code followed by 9 digit mobile number.
     */
    'biller_msisdn' => env('TZ_TIGOPESA_PUSH_BILLER_MSISDN'),

    /**
     * URL for getting authorization token. Provided at time of integration.
     */
    'token_url' => env('TZ_TIGOPESA_PUSH_GET_TOKEN_URL'),

    /**
     * URL for posting bill pay requests. Provided at time of integration.
     */
    'bill_pay_url' => env('TZ_TIGOPESA_PUSH_BILL_PAY_URL'),


    /**
     * Route path to receive tigopesa push callback
     */
    'callback_path' => '/api/tigopesa/callback',

    /**
     * Middleware applied to callback path
     */
    'callback_middleware' => [
        'api',
    ],

];
