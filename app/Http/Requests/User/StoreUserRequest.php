<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'last_name' => 'required|string|max:100',
            'first_name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'phone' => 'required|string|min:8',
            'role_id' => 'required|integer|exists:roles,id',
            'store_id' => 'required|integer|exists:stores,id',
        ];
    }

    public function messages(): array
    {
        return [
            'last_name.required' => 'User last name is required.',
            'first_name.required' => 'User first name is required.',
            'email.required' => 'User email is required.',
            'password.required' => 'User password is required.',
            'password_confirmation.required' => 'User confirm password is required.',
            'phone.required' => 'User phone is required.',
            'role_id.required' => 'User role is required.',
            'role_id.integer' => 'User role must be an integer.',
            'role_id.exists' => 'User role must be an existing role.',
            'email.email' => 'User email must be a valid email address.',
            'email.unique' => 'User email must be unique.',
            'password.min.8' => 'User password must be at least 8 characters.',
            'password_confirmation.min.8' => 'User confirm password must be at least 8 characters.',
            'password.confirmed' => 'User confirm password must be same as password.',
            'store_id.required' => 'Store id is required.',
            'store_id.integer' => 'Store id must be an integer.',
            'store_id.exists' => 'Store id must be an existing store.',
        ];
    }
}
