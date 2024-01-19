<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {
    $api->post('login', [AuthController::class, 'login']);
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->post('logout', [AuthController::class, 'logout']);
    });
});
