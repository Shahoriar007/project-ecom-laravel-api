<?php

namespace App\Http\Requests\EmployeeType;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeTypeRequest extends FormRequest
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
            'name' => ['required', 'string',  'unique:employee_types,name', 'max:255'],
            'description' => ['nullable', 'string']
        ];
    }
}
