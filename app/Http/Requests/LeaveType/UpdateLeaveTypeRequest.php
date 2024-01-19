<?php

namespace App\Http\Requests\LeaveType;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateLeaveTypeRequest extends FormRequest
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
            'name' => ['required', 'string',  'max:255', Rule::unique('leave_types')->ignore($this->leave_type)],
            'employee_type_id' => ['nullable', 'exists:employee_types,id'],
            'gender' => 'in:Male,Female,All',
        ];
    }
}
