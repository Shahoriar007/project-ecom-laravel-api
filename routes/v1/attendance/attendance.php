<?php

use App\Http\Controllers\Api\V1\LeaveTypeController;
use App\Http\Controllers\Api\V1\AttendanceController;
use App\Http\Controllers\Api\V1\LeaveRequestController;
use App\Http\Controllers\Api\V1\AttendanceActivityController;
use App\Http\Controllers\Api\V1\AttendanceStatusController;

$api = app('Dingo\Api\Routing\Router');
$api->version('v1', function ($api) {
    $api->group(['middleware' => 'jwt.auth'], function ($api) {
        // attendance
        $api->get('attendances/is-check-in', [AttendanceController::class, 'isCheckIn']);
        $api->post('attendances/check-in', [AttendanceController::class, 'checkIn']);
        $api->post('attendances/check-out', [AttendanceController::class, 'checkOut']);
        $api->get('attendances/all', [AttendanceController::class, 'all']);
        $api->get('attendances/present-employees', [AttendanceController::class, 'presentEmployees']);
        $api->get('attendances/leave-employees', [AttendanceController::class, 'leaveEmployees']);
        $api->resource('attendances', AttendanceController::class);
        // attendance activities
        $api->resource('attendance-activities', AttendanceActivityController::class);
        // attendance status
        $api->get('attendance-status/all', [AttendanceStatusController::class, 'all']);
        $api->resource('attendance-status', AttendanceStatusController::class);
        // leave
        $api->get('leave-types/eligible/all', [LeaveTypeController::class, 'eligibleAll']);
        $api->get('leave-types/all', [LeaveTypeController::class, 'all']);
        $api->resource('leave-types', LeaveTypeController::class);
        $api->post('leave-requests/{id}/approve', [LeaveRequestController::class, 'approve']);
        $api->resource('leave-requests', LeaveRequestController::class);
    });
});
