<?php

namespace Database\Seeders;

use App\Models\Division;
use Illuminate\Database\Seeder;

class DivisionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $divisions = [[

            'name' => 'Digital Marketing',

        ], [

            'name' => 'Software Development',

        ], [

            'name' => 'Hardware Development',

        ]];


        Division::insert($divisions);
    }
}
