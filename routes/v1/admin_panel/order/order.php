<?php

use App\Http\Controllers\Api\V1\Order\OrderController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('order', [OrderController::class, 'store']);


});
