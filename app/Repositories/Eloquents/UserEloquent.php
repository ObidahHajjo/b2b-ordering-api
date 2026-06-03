<?php

namespace App\Repositories\Eloquents;

use App\Models\User;
use App\Repositories\Interfaces\UserInterface;
use Illuminate\Support\Collection;

class UserEloquent implements UserInterface
{
    /**
     * Get a user by id.
     *
     * @param  int  $id  User id.
     * @return User|null Found user.
     */
    public function getById(int $id): ?User
    {
        return User::with(['role', 'store'])->find($id);
    }

    /**
     * Get a user by email.
     *
     * @param  string  $email  User email.
     * @return User Found user.
     */
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * Get all users.
     *
     * @return Collection<int, User> User collection.
     */
    public function all(): Collection
    {
        return User::with(['role', 'store'])->get();
    }

    /**
     * Create a user.
     *
     * @param  array<string, mixed>  $attributes  User attributes.
     * @return User Created user.
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * Update a user.
     *
     * @param  int  $id  User id.
     * @param  array<string, mixed>  $attributes  User attributes.
     * @return bool True when updated.
     */
    public function update(int $id, array $attributes): bool
    {
        return User::where('id', $id)->update($attributes);
    }

    /**
     * Delete a user.
     *
     * @param  int  $id  User id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        return User::where('id', $id)->delete();
    }
}
