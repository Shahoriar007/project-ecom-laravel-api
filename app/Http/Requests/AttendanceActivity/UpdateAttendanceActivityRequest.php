<?php

namespace App\Http\Requests\AttendanceActivity;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAttendanceActivityRequest extends FormRequest
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
            'check_in' => ['required', 'date_format:H:i:s'],
            'check_out' => ['required', 'after_or_equal:check_in', 'date_format:H:i:s'],
        ];
    }
}
