<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterBusinessRequest extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'business_name' => 'required|string|max:255',
            'industry_type' => 'required|string|max:50',
            'location' => 'required|json',
            'points_per_checkin' => 'nullable|integer|min:1|max:100',
            'conversion_rate' => 'nullable|numeric|min:0.01|max:100',
        ];
    }
}
