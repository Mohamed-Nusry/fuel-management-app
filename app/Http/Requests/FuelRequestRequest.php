<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelRequestRequest extends FormRequest
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
            'fuel_station_id' => 'required',
            'requested_quota' => 'required',
            'expected_date_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fuel_station_id.required' => 'Fuel Station Required!',
            'requested_quota.required' => 'Requested Quota Required!',
            'expected_date_time.required' => 'Expected Date And Time Required!',
        ];
    }
}
