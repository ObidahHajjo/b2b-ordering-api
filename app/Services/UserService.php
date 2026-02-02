<?php

namespace App\Services;

use App\Exceptions\MissingAttributesException;
use App\Interfaces\UserInterface;
use App\Repositories\Interfaces\UserInterface as UserEloquentInterface;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class UserService implements UserInterface
{
    private UserEloquentInterface $userEloquent;

    public function __construct(UserEloquentInterface $userEloquent)
    {
        $this->userEloquent = $userEloquent;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?User
    {
        if (empty($id)) return null;
        try {
            return $this->userEloquent->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): ?User
    {
        if (empty($email) || trim($email) == '') return null;
        try {
            return $this->userEloquent->getByEmail($email);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->userEloquent->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): User
    {
        $required = ['last_name', 'first_name','email','password', 'role_id', 'store_id'];
        $missing = array_diff($required, array_keys($attributes));
        if(!empty($missing)) throw new MissingAttributesException($missing);
        return $this->userEloquent->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        if (empty($id) || empty($attributes)) return false;
        try {
            return $this->userEloquent->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if (empty($id)) return false;
        try {
            return $this->userEloquent->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
