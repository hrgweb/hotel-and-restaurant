<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'nullable',
            'email' => 'nullable|email|unique:users,email',
            'username' => 'nullable',
            'gender' => 'nullable',
            'dob' => 'nullable',
            'role_id' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'role_id.required' => 'The user role is required.'
        ];
    }
}
