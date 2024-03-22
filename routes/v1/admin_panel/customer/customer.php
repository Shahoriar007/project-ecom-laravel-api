<?php

use App\Http\Controllers\Api\V1\Customer\CustomerController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('customers/all', [CustomerController::class, 'index']);

        //customer status changed
        $api->get('customer/band-active/{id}', [CustomerController::class, 'bandActive']);
    });
});
