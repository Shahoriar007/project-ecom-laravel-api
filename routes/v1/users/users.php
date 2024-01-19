<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\Api\V1\User\ProfileController;

$api = app('Dingo\Api\Routing\Router');


$api->version('v1', function ($api) {

    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->resource('users', UserController::class);

        $api->group(['prefix' => 'user'], function ($api) {
            $api->post('/', [AuthController::class, 'user']);
            $api->match(['PUT', 'PATCH'], '/profile/general/update', [ProfileController::class, 'generalUpdate']);
            $api->match(['PUT', 'PATCH'], '/profile/password/update', [ProfileController::class, 'passwordUpdate']);
        });
    });
});
