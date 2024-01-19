<?php

use App\Http\Controllers\Api\V1\DivisionController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('divisions/all', [DivisionController::class, 'all']);
        $api->resource('divisions', DivisionController::class);
    });
});
