<?php

namespace Database\Seeders;

use App\Models\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $leaveTypes = [
            ['name' => 'Bereavement Leave'],
            ['name' => 'Casual Leave'],
            ['name' => 'Casual Leave (Emergency)'],
            ['name' => 'Maternity Leave'],
            ['name' => 'Paternity Leave'],
            ['name' => 'Sick Leave'],
            ['name' => 'Unpaid Leave'],
            ['name' => 'Wedding Leave']
        ];

        LeaveType::insert($leaveTypes);
    }
}
