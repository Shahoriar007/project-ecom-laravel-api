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



        // Permission::insert($permissions);

        $role = Role::create(['name' => RolesService::ADMIN]);
        $permissions = Permission::all();
        $role->givePermissionTo($permissions);
    }
}
