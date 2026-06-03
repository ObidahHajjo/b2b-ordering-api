<?php

namespace App\Http\Requests\Client;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfessionalRegistrationRequest extends FormRequest
{
    /**
     * Allow professional registration validation.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get professional registration rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation rules.
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
            'phone' => ['required', 'string', 'max:16'],
            'company_name' => ['required', 'string', 'max:255'],
            'legal_status' => ['required', 'string', 'max:255'],
            'siret' => ['required', 'string', 'max:20', 'unique:stores,siret'],
            'company_email' => ['required', 'email', 'max:255', 'unique:stores,email'],
            'company_phone' => ['required', 'string', 'max:15', 'unique:stores,phone'],
            'kbis_file' => ['required', 'file', 'mimes:pdf,png,jpg,jpeg', 'max:5120'],
        ];
    }
}
