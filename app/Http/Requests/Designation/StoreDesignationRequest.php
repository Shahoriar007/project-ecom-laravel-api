<?php

namespace App\Http\Requests\Designation;

use Illuminate\Foundation\Http\FormRequest;

class StoreDesignationRequest extends FormRequest
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
            'name' => ['required', 'string',  'unique:designations,name', 'max:255'],
            'description' => ['nullable', 'string'],
            'employee_type_id' => ['nullable', 'exists:employee_types,id'],
        ];
    }
}
