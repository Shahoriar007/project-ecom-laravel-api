<?php

use App\Http\Controllers\Api\V1\Order\OrderController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->post('order', [OrderController::class, 'store']);
    $api->get('customer/{id}/total-order-amount', [OrderController::class, 'totalOrderAmount']);
    $api->get('order-delivery-charge', [OrderController::class, 'getDeliveryCharge']);


    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('orders/all', [OrderController::class, 'index']);
        $api->get('orders/details/{id}', [OrderController::class, 'details']);

        $api->match(['PUT', 'PATCH'], 'order/status/multiple', [OrderController::class, 'statusChangeMultiple']);

        $api->post('update-status', [OrderController::class, 'updateOrderStatus']);

        $api->get('print-invoice', [OrderController::class, 'printInvoice']);
        $api->match(['PUT', 'PATCH'], 'print-sticker', [OrderController::class, 'printSticker']);

        //notification
        $api->get('notifications/user/unread', [OrderController::class, 'getUserUnreadNotifications']);
        $api->match(['PUT', 'PATCH'], 'notification/{id}/mark-as-read', [OrderController::class, 'markAsRead']);

        //delivery charge
        $api->get('delivery-charge', [OrderController::class, 'getDeliveryCharge']);
        $api->post('delivery-charge', [OrderController::class, 'updateDeliveryCharge']);

        //comment
        $api->post('update-comment', [OrderController::class, 'updateComment']);


    });


});
