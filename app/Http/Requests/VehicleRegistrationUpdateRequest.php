<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VehicleRegistrationUpdateRequest extends FormRequest
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
            'vehicle_id' => 'required',
            'email ' => 'required',
            'vehicle_registration_number  ' => 'required',
            'chassis_no  ' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'vehicle_id.required' => 'Vehicle Required!',
            'email.required' => 'Email Required!',
            'vehicle_registration_number.required' => 'Vehicle Registration Required!',
            'chassis_no.required' => 'Chasis No Required!',
        ];
    }
}
