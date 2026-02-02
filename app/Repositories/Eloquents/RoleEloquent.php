<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\RoleInterface;
use App\Models\Role;
use Illuminate\Support\Collection;

class RoleEloquent implements RoleInterface
{
    /**
     * @inheritDoc
     */
    public function getById(int $id): Role
    {
        return Role::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): Role
    {
        return Role::where('name', $name)->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Role::all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Role
    {
        return Role::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        return Role::findOrFail($id)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return Role::findOrFail($id)->delete();
    }
}
