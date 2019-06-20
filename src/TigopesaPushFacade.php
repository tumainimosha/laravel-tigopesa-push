<?php

namespace Tumainimosha\TigopesaPush;

use Illuminate\Support\Facades\Facade;

class TigopesaPushFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'laravel-tigopesa-push';
    }
}
