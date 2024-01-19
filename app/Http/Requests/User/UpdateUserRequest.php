<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', Rule::unique('users')->ignore($this->user)],
            'status' => ['nullable', 'boolean'],
            'role_id' => ['nullable', 'exists:roles,id'],
            'designation_id' => ['nullable', 'exists:designations,id'],
            'gender' => 'in:Male,Female',
            'password' => ['nullable', 'min:6', 'confirmed'],
            'password_confirmation' => ['nullable'],
        ];
    }
}
