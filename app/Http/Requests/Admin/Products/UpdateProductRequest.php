<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Allow product update validation.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get product update rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation rules.
     */
    public function rules(): array
    {
        return [
            'ref' => ['sometimes', 'string', 'max:6'],
            'nom' => ['sometimes', 'string', 'max:50'],
            'prix' => ['sometimes', 'numeric', 'min:0'],
            'poids' => ['sometimes', 'numeric', 'min:0'],
            'liste_ingredient' => ['nullable', 'string'],
            'est_disponible' => ['sometimes', 'boolean'],
        ];
    }
}
