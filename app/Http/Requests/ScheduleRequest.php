<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleRequest extends FormRequest
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
            'scheduled_date_time' => 'required',
            'quota' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'fuel_station_id.required' => 'Fuel Station Required!',
            'scheduled_date_time.required' => 'Scheduled Date And Time Required!',
            'quota.required' => 'Quota Required!',
        ];
    }
}
