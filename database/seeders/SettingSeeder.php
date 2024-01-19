<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'weekends' => [
                ['id' => 1, 'label' => 'Sunday', 'name' => 'sunday', 'code' => 0, 'value' => false],
                ['id' => 2, 'label' => 'Monday', 'name' => 'monday', 'code' => 1, 'value' => false],
                ['id' => 3, 'label' => 'Tuesday', 'name' => 'tuesday', 'code' => 2, 'value' => false],
                ['id' => 4, 'label' => 'Wednesday', 'name' => 'wednesday', 'code' => 3, 'value' => false],
                ['id' => 5, 'label' => 'Thursday', 'name' => 'thursday', 'code' => 4, 'value' => false],
                ['id' => 6, 'label' => 'Friday', 'name' => 'friday', 'code' => 5, 'value' => false],
                ['id' => 7, 'label' => 'Saturday', 'name' => 'saturday', 'code' => 6, 'value' => false],
            ],
            'check_in_out_time' => [
                ['id' => 1, 'label' => 'Check In', 'name' => 'check_in', 'value' => '09:00:00'],
                ['id' => 2, 'label' => 'Check Out', 'name' => 'check_out', 'value' => '18:00:00'],
            ],
        ];

        Setting::create([...$settings]);
    }
}
