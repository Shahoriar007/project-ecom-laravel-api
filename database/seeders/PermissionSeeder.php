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

        $modules = [
            'Dashboard' => [
                ['name' => PermissionsService::DASHBOARD_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
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
                // ['name' => PermissionsService::USERS_PROFILE_SHOW, 'group' => 'others', 'guard_name' => 'api'],
                // ['name' => PermissionsService::USERS_PROFILE_EDIT, 'group' => 'others', 'guard_name' => 'api'],
            ],

            'Parent Categories' => [
                ['name' => PermissionsService::CATEGORIES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::CATEGORIES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::CATEGORIES_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::CATEGORIES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::CATEGORIES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],

            ],

            'Sub Categories' => [
                ['name' => PermissionsService::SUB_CATEGORIES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::SUB_CATEGORIES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::SUB_CATEGORIES_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::SUB_CATEGORIES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::SUB_CATEGORIES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],

            ],

            'Child Categories' => [
                ['name' => PermissionsService::CHILD_CATEGORIES_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::CHILD_CATEGORIES_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::CHILD_CATEGORIES_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::CHILD_CATEGORIES_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::CHILD_CATEGORIES_DELETE, 'group' => 'delete', 'guard_name' => 'api'],

            ],

            'Products' => [
                ['name' => PermissionsService::PRODUCTS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::PRODUCTS_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::PRODUCTS_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::PRODUCTS_EDIT, 'group' => 'edit', 'guard_name' => 'api'],
                ['name' => PermissionsService::PRODUCTS_DELETE, 'group' => 'delete', 'guard_name' => 'api'],

            ],

            'Customer' => [
                ['name' => PermissionsService::CUSTOMERS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::CUSTOMERS_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::CUSTOMERS_BLOCK, 'group' => 'others', 'guard_name' => 'api'],

            ],

            'Orders' => [
                ['name' => PermissionsService::ORDERS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::ORDERS_SHOW, 'group' => 'show', 'guard_name' => 'api'],
                ['name' => PermissionsService::ORDERS_STATUS_CHANGE, 'group' => 'others', 'guard_name' => 'api'],
                ['name' => PermissionsService::ORDERS_FOLLOW_UP_NAME_SHOW, 'group' => 'others', 'guard_name' => 'api'],

            ],

            'Fb Pixel' => [
                ['name' => PermissionsService::FB_PIXEL_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::FB_PIXEL_CREATE, 'group' => 'create', 'guard_name' => 'api'],
                ['name' => PermissionsService::FB_PIXEL_DELETE, 'group' => 'delete', 'guard_name' => 'api'],
            ],

            'Master Settings' => [
                ['name' => PermissionsService::MASTER_SETTINGS_ACCESS, 'group' => 'access', 'guard_name' => 'api'],
                ['name' => PermissionsService::DELIVERY_CHARGE_EDIT, 'group' => 'others', 'guard_name' => 'api'],

            ]


        ];


        foreach ($modules as $key => $permissions) {
            $module = Module::updateOrCreate(['name' => $key], ['name' => $key]);

            foreach ($permissions as $permission) {
                Permission::updateOrCreate([
                    'name' => $permission['name'],
                ], [
                    'name' => $permission['name'],
                    'group' => $permission['group'],
                    'guard_name' => $permission['guard_name'],
                    'module_id' => $module->id
                ]);
            }
        }

        // // $permissions = [];

        $role = Role::updateOrCreate(['name' => RolesService::ADMIN], ['name' => RolesService::ADMIN]);
        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
    }
}
