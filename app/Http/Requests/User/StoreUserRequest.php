<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'status' => ['required', 'boolean'],
            'role_id' => ['required', 'exists:roles,id'],
            'designation_id' => ['required', 'exists:designations,id'],
            'gender' => 'in:Male,Female',
            'password' => ['required', 'min:6', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
}
