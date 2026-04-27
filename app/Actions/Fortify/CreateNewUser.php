<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\AuthService;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        return $this->authService->register($input);
    }
}
