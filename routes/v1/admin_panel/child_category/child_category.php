<?php

use App\Http\Controllers\Api\V1\AdminPanel\ChildCategory\ChildCategoryController;


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    // $api->get('sub-categories/active-all', [SubCategoryController::class, 'activeAll']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('child-categories', ChildCategoryController::class);
    });
});
