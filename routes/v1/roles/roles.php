<?php

use App\Http\Controllers\Api\V1\RoleController;

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('get-modules-permissions', [RoleController::class, 'getModulesPermissions']);
        $api->post('roles/{role}/permission-update', [RoleController::class, 'updatePermission']);
        $api->get('roles/priority-wise', [RoleController::class, 'priorityWiseRoles']);
        $api->get('roles/all', [RoleController::class, 'all']);
        $api->resource('roles', RoleController::class);
    });
});
