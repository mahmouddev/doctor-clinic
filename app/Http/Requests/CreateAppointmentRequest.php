<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateAppointmentRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules =  [
            'dov'      => "required|date",
            'dob'      => "required|date",
            'name'     => "required",
            'type'     => "required|in:check,follow_up",
            'gendar'   => "required|in:male,female",

        ];

        if(!$this->patient_id){
            $rules['phone'] =  "required|unique:patients,phone";
        }

        return $rules;
    }
}
