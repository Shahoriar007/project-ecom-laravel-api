<?php

use App\Http\Controllers\Api\V1\AdminPanel\FbPixel\FbPixelController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    //create a get api for pixel code
    $api->get('fb-pixel-code', [FbPixelController::class, 'getPixelCode']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('fbPixels', FbPixelController::class);
    });
});
