<?php

use App\Http\Controllers\Api\V1\AdminPanel\Product\ProductController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('products', ProductController::class);
    });
});
