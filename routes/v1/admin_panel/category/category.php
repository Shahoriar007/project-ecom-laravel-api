<?php

use App\Http\Controllers\Api\V1\AdminPanel\Category\CategoryController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->resource('category', CategoryController::class);
});
