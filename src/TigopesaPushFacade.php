<?php

namespace Tumainimosha\TigopesaPush;

use Illuminate\Support\Facades\Facade;

/**
 * Class TigopesaPushFacade.
 * @package Tumainimosha\TigopesaPush
 * @method static postRequest (string $customerMsisdn, int $amount, string $txnId, $remarks = '')
 */
class TigopesaPushFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'tigopesa-push';
    }
}
