<?php

use App\Http\Controllers\Api\V1\AdminPanel\Category\CategoryController;
use App\Http\Controllers\Api\V1\AdminPanel\Label\LabelController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('labels/all', [LabelController::class, 'all']);
    });
});
