<?php

use App\Http\Controllers\Api\V1\Order\OrderController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('order', [OrderController::class, 'store']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('orders/all', [OrderController::class, 'index']);
    });


});
