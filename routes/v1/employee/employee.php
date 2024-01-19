<?php

use App\Http\Controllers\Api\V1\EmployeeTypeController;


$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('employee-types/all', [EmployeeTypeController::class, 'all']);
        $api->resource('employee-types', EmployeeTypeController::class);
    });
});
