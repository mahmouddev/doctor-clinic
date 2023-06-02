<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name'     => "nullable|max:190",
            'phone'    => "nullable|max:190",
            'bio'      => "nullable|max:5000",
            'blocked'  => "required|in:0,1",
            'email'    => "required|unique:users,email," . $this->user->id,
            'password' => "nullable|min:8|max:190"
        ];
    }
}
