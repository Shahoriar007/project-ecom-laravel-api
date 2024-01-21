<?php
$api = app('Dingo\Api\Routing\Router');
// auth routes
require __DIR__ . '/v1/auth/auth.php';
// user routes
require __DIR__ . '/v1/users/users.php';
// role routes
require __DIR__ . '/v1/roles/roles.php';
// settings routes
require __DIR__ . '/v1/settings/settings.php';

//admin panel routes
require __DIR__ . '/v1/admin_panel/admin_panel.php';


// $api->version('v1', function ($api) {
//     $api->group(['middleware' => 'jwt.auth'], function ($api) {
//         // Activities Route
//         Route::resource('activities', ActivityController::class);
//         ///Notification
//         Route::resource('/notification', NotificationController::class);
//         Route::get('/notification/read/{id}', [NotificationController::class, 'notificationRead']);
//     });
// });
