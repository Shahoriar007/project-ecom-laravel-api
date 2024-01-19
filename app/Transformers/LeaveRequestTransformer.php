<?php

namespace App\Transformers;

use App\Models\LeaveRequest;
use League\Fractal\TransformerAbstract;

class LeaveRequestTransformer extends TransformerAbstract
{

    protected $availableIncludes = ['leaveType', 'attendances', 'user'];

    public function transform(LeaveRequest $leaveRequest)
    {
        return [
            'id' => $leaveRequest->id,
            'user_id' => $leaveRequest->user_id,
            'leave_type_id' => $leaveRequest->leave_type_id,
            'start_date' => $leaveRequest->start_date,
            'end_date' => $leaveRequest->end_date,
            'status' => (bool)$leaveRequest->status,
            'remarks' => $leaveRequest->remarks,
            'created_at' =>  $leaveRequest->created_at ? $leaveRequest->created_at->toFormattedDateString() : null,
        ];
    }

    public function includeLeaveType(LeaveRequest $leaveRequest)
    {
        if (isset($leaveRequest->leaveType)) {
            return $this->item($leaveRequest->leaveType, new LeaveTypeTransformer());
        }
    }

    public function includeAttendances(LeaveRequest $leaveRequest)
    {
        if (isset($leaveRequest->attendances)) {
            return $this->collection($leaveRequest->attendances, new AttendanceTransformer());
        }
    }

    public function includeUser(LeaveRequest $leaveRequest)
    {
        if (isset($leaveRequest->user)) {
            return $this->item($leaveRequest->user, new UserTransformer());
        }
    }
}
