<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'last_name' => 'sometimes|string|max:100|required_without_all:first_name,email,password,phone',
            'first_name' => 'sometimes|string|max:100|required_without_all:last_name,email,password,phone',
            'email' => 'sometimes|email|max:100|unique:users,email|required_without_all:first_name,last_name,password,password_confirmation,phone',
            'password' => 'sometimes|string|min:8|confirmed|required_without_all:first_name,last_name,email,phone',
            'password_confirmation' => 'sometimes|string|min:8',
            'phone' => 'sometimes|string|min:8|max:16|required_without_all:first_name,last_name,email,password_confirmation,password',
        ];
    }
}
