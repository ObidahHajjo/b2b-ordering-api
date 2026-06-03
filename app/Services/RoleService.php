<?php

namespace App\Services;

use App\Exceptions\MissingAttributesException;
use App\Models\Role;
use App\Repositories\Interfaces\RoleInterface as RoleRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class RoleService
{
    /**
     * Create the role service.
     *
     * @param  RoleRepository  $roleRepository  Role data repository.
     * @return void
     */
    public function __construct(private readonly RoleRepository $roleRepository) {}

    /**
     * Get a role by id.
     *
     * @param  int  $id  Role id.
     * @return Role|null Found role.
     */
    public function getById(int $id): ?Role
    {
        if (empty($id)) {
            return null;
        }

        try {
            return $this->roleRepository->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get a role by name.
     *
     * @param  string  $name  Role name.
     * @return Role|null Found role.
     */
    public function getByName(string $name): ?Role
    {
        if (trim($name) === '') {
            return null;
        }

        try {
            return $this->roleRepository->getByName($name);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get all roles.
     *
     * @return Collection<int, Role> Role collection.
     */
    public function all(): Collection
    {
        return $this->roleRepository->all();
    }

    /**
     * Create a role.
     *
     * @param  array<string, mixed>  $attributes  Role attributes.
     * @return Role Created role.
     *
     * @throws MissingAttributesException When required attributes are missing.
     */
    public function create(array $attributes): Role
    {
        if (! array_key_exists('name', $attributes)) {
            throw new MissingAttributesException(['name']);
        }

        return $this->roleRepository->create($attributes);
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
        if (empty($id)) {
            return false;
        }

        try {
            return $this->roleRepository->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * Delete a role.
     *
     * @param  int  $id  Role id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            return false;
        }

        try {
            return $this->roleRepository->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
