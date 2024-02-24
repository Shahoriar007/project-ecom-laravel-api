<?php


use App\Http\Controllers\Api\V1\AdminPanel\SubCategory\SubCategoryController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('sub-categories/active-all', [SubCategoryController::class, 'activeAll']);

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('sub-categories', SubCategoryController::class);
    });
});
