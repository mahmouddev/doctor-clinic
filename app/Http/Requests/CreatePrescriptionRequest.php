<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePrescriptionRequest extends FormRequest
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
            'dob'               => "required|date",
            'name'              => "required",
            'gendar'            => "required|in:male,female",
            'patient_id'        => "required",
            'appointment_id'    => "required",
            'prescription'      => "required",
            'phone'             => "required"


        ];

        return $rules;
    }
}
