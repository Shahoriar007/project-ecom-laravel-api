<?php

namespace App\Http\Requests\Designation;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDesignationRequest extends FormRequest
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
            'name' => ['required', 'string',  'max:255', Rule::unique('designations')->ignore($this->designation)],
            'description' => ['nullable', 'string'],
            'employee_type_id' => ['nullable', 'exists:employee_types,id'],
        ];
    }
}
