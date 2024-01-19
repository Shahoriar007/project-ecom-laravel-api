<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\SettingSeeder;
use Database\Seeders\DivisionSeeder;
use Database\Seeders\EngineerSeeder;
use Database\Seeders\LeaveTypeSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\DesignationSeeder;
use Database\Seeders\EmployeeTypeSeeder;
use Database\Seeders\AttendanceStatusSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([

            PermissionSeeder::class,
            UserSeeder::class,
            EngineerSeeder::class,
            DivisionSeeder::class,
            DepartmentSeeder::class,
            DesignationSeeder::class,
            LeaveTypeSeeder::class,
            AttendanceStatusSeeder::class,
            EmployeeTypeSeeder::class,
            SettingSeeder::class,

        ]);
    }
}
