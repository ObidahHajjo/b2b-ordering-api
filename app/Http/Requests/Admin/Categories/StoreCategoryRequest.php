<?php

namespace App\Http\Requests\Admin\Categories;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Allow category creation validation.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get category creation rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation rules.
     */
    public function rules(): array
    {
        return [
            'libelle' => ['required', 'string', 'max:50'],
        ];
    }
}
