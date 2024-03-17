<?php

use App\Http\Controllers\Api\V1\Order\OrderController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('order', [OrderController::class, 'store']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('orders/all', [OrderController::class, 'index']);
        $api->get('orders/details/{id}', [OrderController::class, 'details']);

        $api->match(['PUT', 'PATCH'], 'order/status/multiple', [OrderController::class, 'statusChangeMultiple']);

        $api->post('update-status', [OrderController::class, 'updateOrderStatus']);

        $api->get('print-invoice', [OrderController::class, 'printInvoice']);
        $api->match(['PUT', 'PATCH'], 'print-sticker', [OrderController::class, 'printSticker']);

    });


});
