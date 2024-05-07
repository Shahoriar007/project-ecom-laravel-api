<?php

use App\Http\Controllers\Api\V1\AdminPanel\Product\ProductController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('active-products', [ProductController::class, 'activeAll']);

    $api->get('total-products', [ProductController::class, 'totalProducts']);
    $api->get('products/{slug}', [ProductController::class, 'showWithSlug']);

    //search product
    $api->get('product-search', [ProductController::class, 'searchProduct']);
    //get related product
    $api->get('related-products/{id}', [ProductController::class, 'relatedProducts']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('products', ProductController::class);

        $api->get('product/status/update/{id}', [ProductController::class, 'updateStatus']);
    });
});
