<?php

namespace Database\Seeders;

use App\Models\Module;
use App\Services\Constant\PermissionsService;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Services\Constant\RolesService;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Table::truncate();
        $roles = [
            ['guard_name' => 'api', 'name' => RolesService::HR, 'priority' => 1],
            ['guard_name' => 'api', 'name' => RolesService::EMPLOYEE, 'priority' => 2],
        ];

        $modules = [
            'Dashboard' => [
                ['name' => PermissionsService::DASHBOARD_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
            ],
            'Division' => [
                ['name' => PermissionsService::DIVISION_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::DIVISION_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::DIVISION_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::DIVISION_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],
            'Department' => [
                ['name' => PermissionsService::DEPARTMENT_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_EMPLOYEE_ADD, 'group' => 'others', 'guard_name' => 'api'],
                ['name' => PermissionsService::DEPARTMENT_EMPLOYEE_DELETE, 'group' => 'others', 'guard_name' => 'api'],
            ],
            'Designation' => [
                ['name' => PermissionsService::DESIGNATION_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::DESIGNATION_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::DESIGNATION_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::DESIGNATION_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::DESIGNATION_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],

            'Roles' => [
                ['name' => PermissionsService::ROLES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::ROLES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::ROLES_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::ROLES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::ROLES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],

            'Users' => [
                ['name' => PermissionsService::USERS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_PROFILE_SHOW, 'group' => 'others', 'guard_name' => 'api'],
                ['name' => PermissionsService::USERS_PROFILE_EDIT, 'group' => 'others', 'guard_name' => 'api'],
            ],

            'Employee Types' => [
                ['name' => PermissionsService::EMPLOYEE_TYPES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::EMPLOYEE_TYPES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::EMPLOYEE_TYPES_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::EMPLOYEE_TYPES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::EMPLOYEE_TYPES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],

            'Settings' => [
                ['name' => PermissionsService::SETTINGS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::SETTINGS_GENERAL_ACCESS, 'group' => 'others', 'guard_name' => 'api'],
            ],

            'Attendance Management' => [
                ['name' => PermissionsService::ATTENDANCE_MANAGEMENT_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::ATTENDANCE_CALENDER_ACCESS, 'group' => 'others', 'guard_name' => 'api'],
            ],

            'Attendance' => [
                ['name' => PermissionsService::ATTENDANCE_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::ATTENDANCE_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::ATTENDANCE_DETAILS_EDIT, 'group' => 'others', 'guard_name' => 'api'],
            ],

            'Leave Management' => [
                ['name' => PermissionsService::Leave_MANAGEMENT_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
            ],

            'Leave Types' => [
                ['name' => PermissionsService::LEAVE_TYPES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_TYPES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_TYPES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_TYPES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],

            'Leave Requests' => [
                ['name' => PermissionsService::LEAVE_REQUESTS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_REQUESTS_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_REQUESTS_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_REQUESTS_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
                ['name' => PermissionsService::LEAVE_REQUESTS_APPROVE, 'group' => 'others', 'guard_name' => 'api'],
            ],
        ];

        foreach ($modules as $key => $permissions) {
            $module = Module::create(['name' => $key]);
            foreach ($permissions as $permission)
                Permission::create([
                    'name' => $permission['name'],
                    'group' => $permission['group'],
                    'guard_name' => $permission['guard_name'],
                    'module_id' => $module->id
                ]);
        }

        // $permissions = [];

        Role::insert($roles);
        // Permission::insert($permissions);

        $role = Role::create(['name' => RolesService::ADMIN, 'priority' => 0]);
        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
    }
}
