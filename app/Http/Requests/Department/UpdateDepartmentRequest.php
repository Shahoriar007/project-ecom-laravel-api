<?php

namespace App\Http\Requests\Department;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateDepartmentRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255',  Rule::unique('departments')->ignore($this->department)],
            'division_id' => ['nullable', 'integer'],
            'head_id' => ['nullable', 'integer']
        ];
    }
}
