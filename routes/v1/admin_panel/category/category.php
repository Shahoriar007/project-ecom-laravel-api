<?php

use App\Http\Controllers\Api\V1\AdminPanel\Category\CategoryController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('categories', CategoryController::class);
    });
});
