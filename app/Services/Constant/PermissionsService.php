<?php

namespace App\Services\Constant;

class PermissionsService
{
    // Dashboard
    public const DASHBOARD_ACCESS = 'dashboard_access';

    // Division
    public const DIVISION_ACCESS = 'division_access';
    public const DIVISION_CREATE = 'division_create';
    public const DIVISION_EDIT = 'division_edit';
    public const DIVISION_DELETE = 'division_delete';

    // Department
    public const DEPARTMENT_ACCESS = 'department_access';
    public const DEPARTMENT_CREATE = 'department_create';
    public const DEPARTMENT_SHOW = 'department_show';
    public const DEPARTMENT_EDIT = 'department_edit';
    public const DEPARTMENT_DELETE = 'department_delete';
    public const DEPARTMENT_EMPLOYEE_ADD = 'department_employee_add';
    public const DEPARTMENT_EMPLOYEE_DELETE = 'department_employee_delete';

    // Designations
    public const DESIGNATION_ACCESS = 'designation_access';
    public const DESIGNATION_CREATE = 'designation_create';
    public const DESIGNATION_SHOW = 'designation_show';
    public const DESIGNATION_EDIT = 'designation_edit';
    public const DESIGNATION_DELETE = 'designation_delete';

    // Roles
    public const ROLES_ACCESS = 'roles_access';
    public const ROLES_CREATE = 'roles_create';
    public const ROLES_SHOW = 'roles_show';
    public const ROLES_EDIT = 'roles_edit';
    public const ROLES_DELETE = 'roles_delete';

    // Users
    public const USERS_ACCESS = 'users_access';
    public const USERS_CREATE = 'users_create';
    public const USERS_SHOW = 'users_show';
    public const USERS_EDIT = 'users_edit';
    public const USERS_DELETE = 'users_delete';
    public const USERS_PROFILE_SHOW = 'users_profile_show';
    public const USERS_PROFILE_EDIT = 'users_profile_edit';

    // Employee Types
    public const EMPLOYEE_TYPES_ACCESS = 'employee_types_access';
    public const EMPLOYEE_TYPES_CREATE = 'employee_types_create';
    public const EMPLOYEE_TYPES_SHOW = 'employee_types_show';
    public const EMPLOYEE_TYPES_EDIT = 'employee_types_edit';
    public const EMPLOYEE_TYPES_DELETE = 'employee_types_delete';

    // Settings
    public const SETTINGS_ACCESS = 'settings_access';
    public const SETTINGS_GENERAL_ACCESS = 'settings_general_access';

    // Attendance Management
    public const ATTENDANCE_MANAGEMENT_ACCESS = 'attendance_management_access';
    public const ATTENDANCE_CALENDER_ACCESS = 'attendance_calender_access';

    // Attendance
    public const ATTENDANCE_ACCESS = 'attendance_access';
    public const ATTENDANCE_SHOW = 'attendance_show';
    public const ATTENDANCE_DETAILS_EDIT = 'attendance_details_edit';

    // Leave Management
    public const Leave_MANAGEMENT_ACCESS = 'leave_management_access';

    // Leave Types
    public const LEAVE_TYPES_ACCESS = 'leave_types_access';
    public const LEAVE_TYPES_CREATE = 'leave_types_create';
    public const LEAVE_TYPES_EDIT = 'leave_types_edit';
    public const LEAVE_TYPES_DELETE = 'leave_types_delete';

    //Leave Requests
    public const LEAVE_REQUESTS_ACCESS = 'leave_requests_access';
    public const LEAVE_REQUESTS_CREATE = 'leave_requests_create';
    public const LEAVE_REQUESTS_EDIT = 'leave_requests_edit';
    public const LEAVE_REQUESTS_DELETE = 'leave_requests_delete';
    public const LEAVE_REQUESTS_APPROVE = 'leave_requests_approve';
}
