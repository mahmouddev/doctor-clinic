<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePatientRequest extends FormRequest
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
        return [
            'name'     => "required",
            'phone'    => "required|unique:patients,phone",
            'dob'      => "required|date",
            'email'    => "nullable|unique:patients,email",
            'gendar'   => "required|in:male,female",

        ];
    }
}
