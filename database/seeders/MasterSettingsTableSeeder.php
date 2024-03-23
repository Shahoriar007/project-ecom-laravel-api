<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MasterSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('master_settings')->insert([
            'inside_dhaka' => 50.00,
            'outside_dhaka' => 100.00,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
