<?php

namespace App\Http\Requests\Admin\Products;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Allow product creation validation.
     *
     * @return bool Always true.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get product creation rules.
     *
     * @return array<string, ValidationRule|array<mixed>|string> Validation rules.
     */
    public function rules(): array
    {
        return [
            'ref' => ['required', 'string', 'max:6'],
            'nom' => ['required', 'string', 'max:50'],
            'prix' => ['required', 'numeric', 'min:0'],
            'poids' => ['required', 'numeric', 'min:0'],
            'liste_ingredient' => ['nullable', 'string'],
            'est_disponible' => ['sometimes', 'boolean'],
        ];
    }
}
