<?php

use App\Http\Controllers\Api\V1\AdminPanel\Product\ProductController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('active-products', [ProductController::class, 'activeAll']);
    $api->get('products/{slug}', [ProductController::class, 'showWithSlug']);
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('products', ProductController::class);
    });
});
