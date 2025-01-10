<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $userId = Auth::user()->id;
        return [
            'user_name' => [
                'required', 'string', 'max:20',
                Rule::unique('users', 'user_name')->ignore($userId)->whereNotNull('email_verified_at')
            ],
            'user_first_name' => 'required|string|max:50',
            'user_last_name' => 'required|string|max:50',
            'email' => [
                'required', 'string', 'email', 'max:50',
                Rule::unique('users', 'email')->ignore($userId)->whereNotNull('email_verified_at')
            ],
            'password' => 'nullable|min:4',
            'user_mobile' => [
                'required', 'string', 'max:15',
                Rule::unique('users', 'user_mobile')->ignore($userId)->whereNotNull('email_verified_at')
            ],
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,id',
        ];
    }

    public function messages()
    {
        return [
            'user_name.required' => 'The username field is required.',
            'user_name.string' => 'The username must be a string.',
            'user_name.max' => 'The username must not exceed 20 characters.',
            'user_name.unique' => 'This username is already taken.',

            'user_first_name.required' => 'The first name field is required.',
            'user_first_name.string' => 'The first name must be a string.',
            'user_first_name.max' => 'The first name must not exceed 50 characters.',

            'user_last_name.required' => 'The last name field is required.',
            'user_last_name.string' => 'The last name must be a string.',
            'user_last_name.max' => 'The last name must not exceed 50 characters.',

            'email.required' => 'The email field is required.',
            'email.string' => 'The email must be a string.',
            'email.email' => 'Please provide a valid email address.',
            'email.max' => 'The email must not exceed 50 characters.',
            'email.unique' => 'This email address is already registered.',

            'password.min' => 'The password must be at least 4 characters long.',

            'user_mobile.required' => 'The mobile number field is required.',
            'user_mobile.string' => 'The mobile number must be a string.',
            'user_mobile.max' => 'The mobile number must not exceed 15 characters.',
            'user_mobile.unique' => 'This mobile number is already registered.',

            'roles.required' => 'At least one role must be selected.',
            'roles.array' => 'Roles must be an array.',
            'roles.min' => 'At least one role is required.',
            'roles.invalid' => 'The selected roles are invalid.',
        ];
    }

}
