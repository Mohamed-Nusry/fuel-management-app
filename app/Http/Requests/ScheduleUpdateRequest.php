<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleUpdateRequest extends FormRequest
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
            'scheduled_date_time' => 'required',
            'quota' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'scheduled_date_time.required' => 'Scheduled Date And Time Required!',
            'quota.required' => 'Quota Required!',
        ];
    }
}