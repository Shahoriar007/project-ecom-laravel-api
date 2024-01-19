<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AttendanceStatus;
use App\Services\Constant\AttendanceStatusService;

class AttendanceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $attendanceStatus = [
            ['name' => AttendanceStatusService::PRESENT, 'sort_name' => 'P', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::ABSENT, 'sort_name' => 'A', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::DELAY, 'sort_name' => 'D', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::EARLY_CHECK_OUT, 'sort_name' => 'E', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::HOLIDAY, 'sort_name' => 'H', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::LEAVE, 'sort_name' => 'L', 'color_code' => null, 'class' => null],
            ['name' =>  AttendanceStatusService::WEEKEND, 'sort_name' => 'W', 'color_code' => null, 'class' => null],
        ];

        AttendanceStatus::insert($attendanceStatus);
    }
}
