<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationRequest extends FormRequest
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

    public function rules()
    {
        return [
            'user_name' => [
                'required', 'string', 'max:20',
                Rule::unique('users', 'user_name')->whereNotNull('email_verified_at')
            ],
            'user_first_name' => 'required|string|max:50',
            'user_last_name' => 'required|string|max:50',
            'email' => [
                'required', 'string', 'email', 'max:50',
                Rule::unique('users', 'email')->whereNotNull('email_verified_at')
            ],
            'password' => 'required|string|min:4',
            'confirm_password' => 'required|same:password',
            'user_mobile' => [
                'required', 'string', 'max:15',
                Rule::unique('users', 'user_mobile')->whereNotNull('email_verified_at')
            ],
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'Username is required.',
            'user_name.unique' => 'Username is already taken.',
            'user_name.max' => 'Username must not exceed 20 characters.',

            'user_first_name.required' => 'First name is required.',
            'user_first_name.max' => 'First name must not exceed 50 characters.',

            'user_last_name.required' => 'Last name is required.',
            'user_last_name.max' => 'Last name must not exceed 50 characters.',

            'email.required' => 'Email is required.',
            'email.email' => 'Invalid email format.',
            'email.unique' => 'Email is already registered.',
            'email.max' => 'Email must not exceed 50 characters.',

            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 4 characters.',

            'confirm_password.required' => 'Confirm password is required.',
            'confirm_password.same' => 'Confirm password must match the password.',

            'user_mobile.required' => 'Mobile number is required.',
            'user_mobile.unique' => 'Mobile number is already registered.',
            'user_mobile.max' => 'Mobile number must not exceed 15 characters.',
        ];
    }

}
