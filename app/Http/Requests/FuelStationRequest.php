<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuelStationRequest extends FormRequest
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
            'district_id' => 'required',
            'code' => 'required',
            'name' => 'required',
            'available_quota' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'district_id.required' => 'District Required!',
            'code.required' => 'Code Required!',
            'name.required' => 'Name Required!',
            'available_quota.required' => 'Available Quota Required!',
        ];
    }
}
