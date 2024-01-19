<?php


$api = app('Dingo\Api\Routing\Router');
// auth routes
require __DIR__ . '/v1/auth/auth.php';
// user routes
require __DIR__ . '/v1/users/users.php';
//division routes
require __DIR__ . '/v1/division/division.php';
//department routes
require __DIR__ . '/v1/department/department.php';
//designation routes
require __DIR__ . '/v1/designation/designation.php';
// Role routes
require __DIR__ . '/v1/roles/roles.php';
// Attendance routes
require __DIR__ . '/v1/attendance/attendance.php';
// employee routes
require __DIR__ . '/v1/employee/employee.php';
// settings routes
require __DIR__ . '/v1/settings/settings.php';

// $api->version('v1', function ($api) {
//     $api->group(['middleware' => 'jwt.auth'], function ($api) {
//         // Activities Route
//         Route::resource('activities', ActivityController::class);
//         ///Notification
//         Route::resource('/notification', NotificationController::class);
//         Route::get('/notification/read/{id}', [NotificationController::class, 'notificationRead']);
//     });
// });
