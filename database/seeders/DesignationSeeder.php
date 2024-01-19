<?php

namespace Database\Seeders;

use App\Models\Designation;
use Illuminate\Database\Seeder;

class DesignationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $designations = [
            ['name' => 'CEO'],
            ['name' => 'CTO',],
            ['name' => 'Quality Assurance Engineer'],
            ['name' => 'Senior Software Developer'],
            ['name' => 'Junior Software Developer'],
            ['name' => 'Junior Wordpress Developer'],
            ['name' => 'Senior Wordpress Developer']
        ];


        Designation::insert($designations);
    }
}
