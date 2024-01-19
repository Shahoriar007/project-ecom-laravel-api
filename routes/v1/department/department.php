<?php


use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\User\UserController;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        $api->get('/department/{id}/users/search', [UserController::class, 'searchUsers']);
        $api->get('/department/{id}/users', [UserController::class, 'departmentUsers']);
        $api->post('/sync-user-department', [DepartmentController::class, 'syncUserToDepartment']);
        $api->resource('departments', DepartmentController::class);
    });
});
