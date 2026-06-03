<?php

namespace App\Services;

use App\Exceptions\MissingAttributesException;
use App\Models\User;
use App\Repositories\Interfaces\UserInterface as UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UserService
{
    /**
     * Create the user service.
     *
     * @param  UserRepository  $userRepository  User data repository.
     * @return void
     */
    public function __construct(private readonly UserRepository $userRepository) {}

    /**
     * Get a user by id.
     *
     * @param  int  $id  User id.
     * @return User|null Found user.
     */
    public function getById(int $id): ?User
    {
        if (empty($id)) {
            return null;
        }

        return $this->userRepository->getById($id);
    }

    /**
     * Get a user by email.
     *
     * @param  string  $email  User email.
     * @return User|null Found user.
     */
    public function getByEmail(string $email): ?User
    {
        if (trim($email) === '') {
            return null;
        }

        try {
            return $this->userRepository->getByEmail($email);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get all users.
     *
     * @return Collection<int, User> User collection.
     */
    public function all(): Collection
    {
        return $this->userRepository->all();
    }

    /**
     * Create a user.
     *
     * @param  array<string, mixed>  $attributes  User attributes.
     * @return User Created user.
     *
     * @throws MissingAttributesException When required attributes are missing.
     */
    public function create(array $attributes): User
    {
        $required = ['last_name', 'first_name', 'email', 'password', 'role_id', 'store_id'];
        $missing = array_diff($required, array_keys($attributes));
        if (! empty($missing)) {
            throw new MissingAttributesException($missing);
        }

        return $this->userRepository->create($attributes);
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
        if (empty($id) || empty($attributes)) {
            return false;
        }

        try {
            return $this->userRepository->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * Delete a user.
     *
     * @param  int  $id  User id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            return false;
        }

        try {
            return $this->userRepository->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
