<?php

namespace Database\Seeders;

use App\Models\EmployeeType;
use Illuminate\Database\Seeder;

class EmployeeTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employeeTypes = [
            ['name' => 'Contractual'],
            ['name' => 'Probationary',],
            ['name' => 'Intern'],
            ['name' => 'Part-Time'],
            ['name' => 'Full-Time'],

        ];

        EmployeeType::insert($employeeTypes);
    }
}
