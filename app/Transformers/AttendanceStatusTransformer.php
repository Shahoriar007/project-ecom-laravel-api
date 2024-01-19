<?php

namespace App\Transformers;

use App\Models\AttendanceStatus;
use League\Fractal\TransformerAbstract;

class AttendanceStatusTransformer extends TransformerAbstract
{

    public function transform(AttendanceStatus $attendanceStatus)
    {
        return [
            'id' => $attendanceStatus->id,
            'name' => $attendanceStatus->name,
            'sort_name' => $attendanceStatus->sort_name,
            'color_code' => $attendanceStatus->color_code,
            'class' => $attendanceStatus->class,
        ];
    }
}
