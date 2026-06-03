<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Services\AuthService;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Create the Fortify user action.
     *
     * @param  AuthService  $authService  Auth business service.
     * @return void
     */
    public function __construct(private readonly AuthService $authService) {}

    /**
     * Validate and create a user.
     *
     * @param  array<string, string>  $input  Registration input.
     * @return User Created user.
     */
    public function create(array $input): User
    {
        return $this->authService->register($input);
    }
}
