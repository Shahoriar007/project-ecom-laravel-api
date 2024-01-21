<?php

use App\Http\Controllers\Api\V1\AdminPanel\Product\ProductController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->resource('product', ProductController::class);
});
