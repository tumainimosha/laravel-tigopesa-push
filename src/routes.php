<?php

use \Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'Tumainimosha\TigopesaPush\Http\Controllers'], function () {

    /**
     * Process Callback Route.
     */
    $callback_path = config('tigopesa-push.callback_path');
    $callback_middlewares = config('tigopesa-push.callback_middleware');

    Route::post($callback_path, 'CallbackController')
        ->middleware($callback_middlewares);
});
