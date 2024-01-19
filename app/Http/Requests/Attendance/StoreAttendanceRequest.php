<?php

namespace App\Http\Requests\Attendance;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class StoreAttendanceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_id' => ['required', 'integer'],
            'leave_request_id' => ['exists:leave_requests,id'],
            'leave_type_id' => ['exists:leave_types,id'],
            'date' => ['required', 'date'],
            'first_check_in' => ['nullable', 'date_format:H:i:s'],
            'last_check_out' => ['nullable', 'date_format:H:i:s'],
            'on_leave' => ['boolean'],
        ];
    }
}
