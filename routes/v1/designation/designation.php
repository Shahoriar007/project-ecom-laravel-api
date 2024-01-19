<?php

use App\Http\Controllers\Api\V1\DesignationController;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        // Designation routes
        $api->get('designations/all', [DesignationController::class, 'all']);
        $api->resource('designations', DesignationController::class);
    });
});
