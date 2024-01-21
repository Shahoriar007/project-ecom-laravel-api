<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Contracts\Role;
use App\Services\Constant\RolesService;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),


            ],

        ];

        foreach ($users as $item) {

            $user = User::create($item);
            if ($item['name'] == 'admin') {
                $user->assignRole(RolesService::ADMIN);
            } else {
                $user->assignRole(RolesService::EMPLOYEE);
            }
        }
    }
}
