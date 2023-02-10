<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelStationUpdateRequest extends FormRequest
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
            'code' => 'required',
            'name' => 'required',
            'available_quota' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Code Required!',
            'name.required' => 'Name Required!',
            'available_quota.required' => 'Available Quota Required!',
        ];
    }
}
