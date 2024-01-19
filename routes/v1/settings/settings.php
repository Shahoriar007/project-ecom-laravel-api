<?php

use App\Http\Controllers\Api\V1\SettingController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('settings', [SettingController::class, 'index']);
        $api->post('settings', [SettingController::class, 'update']);
    });
});
