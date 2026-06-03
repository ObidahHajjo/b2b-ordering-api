<?php

namespace App\Repositories\Eloquents;

use App\Models\Role;
use App\Repositories\Interfaces\RoleInterface;
use Illuminate\Support\Collection;

class RoleEloquent implements RoleInterface
{
    /**
     * Get a role by id.
     *
     * @param  int  $id  Role id.
     * @return Role Found role.
     */
    public function getById(int $id): Role
    {
        return Role::findOrFail($id);
    }

    /**
     * Get a role by name.
     *
     * @param  string  $name  Role name.
     * @return Role Found role.
     */
    public function getByName(string $name): Role
    {
        return Role::where('name', $name)->firstOrFail();
    }

    /**
     * Get all roles.
     *
     * @return Collection<int, Role> Role collection.
     */
    public function all(): Collection
    {
        return Role::all();
    }

    /**
     * Create a role.
     *
     * @param  array<string, mixed>  $attributes  Role attributes.
     * @return Role Created role.
     */
    public function create(array $attributes): Role
    {
        return Role::create($attributes);
    }

    /**
     * Update a role.
     *
     * @param  int  $id  Role id.
     * @param  array<string, mixed>  $attributes  Role attributes.
     * @return bool True when updated.
     */
    public function update(int $id, array $attributes): bool
    {
        return Role::findOrFail($id)->update($attributes);
    }

    /**
     * Delete a role.
     *
     * @param  int  $id  Role id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        return Role::findOrFail($id)->delete();
    }
}
