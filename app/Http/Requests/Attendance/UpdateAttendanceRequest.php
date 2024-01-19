<?php

namespace App\Http\Requests\Attendance;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceRequest extends FormRequest
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
            'user_id' => ['nullable', 'integer'],
            'leave_request_id' => ['nullable', 'exists:leave_requests,id'],
            'leave_type_id' => ['nullable', 'exists:leave_types,id'],
            'date' => ['nullable', 'date'],
            'first_check_in' => ['nullable', 'date_format:H:i:s'],
            'last_check_out' => ['nullable', 'date_format:H:i:s'],
            'on_leave' => ['boolean'],
        ];
    }
}
