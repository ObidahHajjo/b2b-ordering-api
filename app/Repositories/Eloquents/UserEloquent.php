<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\UserInterface;
use App\Models\User;
use Illuminate\Support\Collection;

class UserEloquent implements UserInterface
{

    /**
     * @inheritDoc
     */
    public function getById(int $id): User
    {
        return User::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getByEmail(string $email): User
    {
        return User::where('email', $email)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return User::all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): User
    {
        return User::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        return User::where('id', $id)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return User::where('id', $id)->delete();
    }
}
