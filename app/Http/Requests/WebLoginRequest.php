<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;

class WebLoginRequest extends FormRequest
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
            'identifier' => 'required',
            'password' => 'required|min:4',
        ];
    }

    public function messages()
    {
        return [
            'email.required'=>'The email field is required',
            'password.required'=>'The password field is required',
        ];
    }

}
