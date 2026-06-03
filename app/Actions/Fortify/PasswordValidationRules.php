<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get password validation rules.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string> Password rules.
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', Password::default(), 'confirmed'];
    }
}
