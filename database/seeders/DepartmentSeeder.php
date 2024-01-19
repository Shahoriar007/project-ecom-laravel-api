<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $departments = [
            [

                'name' => 'SEO Engineering',

            ], [

                'name' => 'Laravel Development',

            ],
            [

                'name' => 'Wordpress Development',

            ],
            [

                'name' => 'IOT Development',

            ]
        ];


        Department::insert($departments);
    }
}
