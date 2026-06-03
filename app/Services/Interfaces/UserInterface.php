<?php

namespace App\Services\Interfaces;

use App\Exceptions\MissingAttributesException;
use App\Models\User;
use Illuminate\Support\Collection;

interface UserInterface
{
    /**
     * Get a user by his id
     *
     * @param int $id user unique identity
     * @return User|null User object
     */
    public function getById(int $id): ?User;

    /**
     * Get a user by his email
     *
     * @param string $email user unique name
     * @return User|null User object
     */
    public function getByEmail(string $email): ?User;

    /**
     * Get all users
     *
     * @return Collection an array with all the users
     */
    public function all(): Collection;

    /**
     * Create a new user record
     *
     * @param array $attributes user object attributes
     * @return User the created User object
     * @throws MissingAttributesException if attributes is missing required attribute
     */
    public function create(array $attributes): User;

    /**
     * Create a new user record
     *
     * @param int $id the unique identity of user object
     * @param array $attributes user object attributes
     * @return bool true if modified, false if not
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Create a new user record
     *
     * @param int $id the unique identity of user object
     * @return bool true if deleted, false if not
     */
    public function delete(int $id): bool;
}
