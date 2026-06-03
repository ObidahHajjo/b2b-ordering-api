<?php

namespace App\Http\Requests\Auth;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Allow registration validation.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get registration validation rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation rules.
     */
    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'required_without:first_name', 'string', 'max:255'],
            'first_name' => ['sometimes', 'required_without:name', 'string', 'max:100'],
            'last_name' => ['nullable', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }
}
