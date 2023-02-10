<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'first_name.required' => 'First Name Required!',
            'last_name.required' => 'Last Name Required!',
            'name.required' => 'Name Required!',
            'email.required' => 'Email Required!',
            'email.email'    => 'Must be a valid email!',
            'password.required' => 'Password Required!'
        ];
    }
}
