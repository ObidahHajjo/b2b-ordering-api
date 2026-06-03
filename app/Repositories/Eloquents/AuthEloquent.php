<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\AuthRepositoryInterface;

class AuthEloquent implements AuthRepositoryInterface
{
    /**
     * Find a user by email.
     *
     * @param  string  $email  User email.
     * @return User|null Found user.
     */
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /**
     * Create a user.
     *
     * @param  array<string, mixed>  $attributes  User attributes.
     * @return User Created user.
     */
    public function createUser(array $attributes): User
    {
        return User::create($attributes);
    }
}
