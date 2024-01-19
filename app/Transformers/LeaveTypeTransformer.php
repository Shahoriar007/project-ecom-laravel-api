<?php


namespace App\Transformers;

use App\Models\LeaveType;
use League\Fractal\TransformerAbstract;
use App\Transformers\EmployeeTypeTransformer;

class LeaveTypeTransformer extends TransformerAbstract
{
    protected $availableIncludes = ['attendances', 'leaveRequests', 'employeeType'];
    public function transform(LeaveType $leaveType)
    {
        return [
            'id' => $leaveType->id,
            'name' => $leaveType->name,
            'leave_requests_count' => $leaveType->leave_requests_count,
            'gender' => $leaveType->gender,
            'employee_type_id' => $leaveType->employee_type_id,
            'created_at' =>  $leaveType->created_at ? $leaveType->created_at->toFormattedDateString() : null,
        ];
    }

    public function includeAttendances(LeaveType $leaveType)
    {
        if (isset($leaveType->attendances)) {
            return $this->collection($leaveType->attendances, new AttendanceTransformer());
        }
    }

    public function includeLeaveRequests(LeaveType $leaveType)
    {
        if (isset($leaveType->leaveRequests)) {
            return $this->collection($leaveType->leaveRequests, new LeaveRequestTransformer());
        }
    }

    public function includeEmployeeType(LeaveType $leaveType)
    {
        if (isset($leaveType->employeeType)) {
            return $this->item($leaveType->employeeType, new EmployeeTypeTransformer());
        }
    }
}
