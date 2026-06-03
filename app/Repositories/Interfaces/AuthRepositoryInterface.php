<?php

namespace App\Repositories\Interfaces;

use App\Models\User;

interface AuthRepositoryInterface
{
    /**
     * Find a user by email.
     *
     * @param  string  $email  User email.
     * @return User|null Found user.
     */
    public function findByEmail(string $email): ?User;

    /**
     * Create a user.
     *
     * @param  array<string, mixed>  $attributes  User attributes.
     * @return User Created user.
     */
    public function createUser(array $attributes): User;
}
