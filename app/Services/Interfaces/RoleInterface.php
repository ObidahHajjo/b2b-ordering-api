<?php

namespace App\Services\Interfaces;

use App\Exceptions\MissingAttributesException;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface RoleInterface
{
    /**
     * Get a role by his id
     *
     * @param int $id role unique identity
     * @return Role|null Role object, or null if not found
     */
    public function getById(int $id): ?Role;

    /**
     * Get a role by his name
     *
     * @param string $name role unique name
     * @return Role|null Role object, or null if not found
     */
    public function getByName(string $name): ?Role;

    /**
     * Get all roles
     *
     * @return Collection an array with all the roles, or empty array
     */
    public function all(): Collection;

    /**
     * Create a new role instance
     *
     * @param array $attributes The role attributes
     * @return Role new Role object
     * @throws MissingAttributesException if some attributes are missed
     */
    public function create(array $attributes): Role;

    /**
     * update an exists role instance
     *
     * @param array $attributes The role attributes
     * @return bool true if the role has been modified successfully, false if not
     */
    public function update(int $id, array $attributes): bool;

    /**
     * delete an exists role instance
     *
     * @return bool true if the role has been deleted successfully, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function delete(int $id): bool;
}
