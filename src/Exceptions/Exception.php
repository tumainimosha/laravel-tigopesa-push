<?php

namespace Tumainimosha\TigopesaPush\Exceptions;

use Exception as BaseException;

class Exception extends BaseException
{
    /**
     * @var array
     */
    public $response;

    /**
     * @param array $response
     * @return \Tumainimosha\TigopesaPush\Exceptions\Exception
     */
    public static function authenticationError($response = [])
    {
        $exception = new static('Error authenticating to Tigopesa Push API');
        $exception->response = $response;

        return $exception;
    }

    /**
     * @param array $response
     * @return Exception
     */
    public static function billerPayError($response = [])
    {
        $exception = new static('Error posting billPay request to Tigopesa Push API');
        $exception->response = $response;

        return $exception;
    }
}
