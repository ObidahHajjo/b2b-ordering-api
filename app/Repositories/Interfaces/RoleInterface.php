<?php

namespace App\Repositories\Interfaces;

use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface RoleInterface
{
    /**
     * Get a role by his id
     *
     * @param int $id role unique identity
     * @return Role Role object
     * @throws ModelNotFoundException if no record found
     */
    public function getById(int $id) : Role;

    /**
     * Get a role by his name
     *
     * @param string $name role unique name
     * @return Role Role object
     * @throws ModelNotFoundException if no record found
     */
    public function getByName(string $name): Role;

    /**
     * Get all roles
     *
     * @return Collection an array with all the roles
     */
    public function all() : Collection;

    /**
     * Create a new role record
     *
     * @param array $attributes role object attributes
     * @return Role the created Role object
     */
    public function create(array $attributes): Role;

    /**
     * Create a new role record
     *
     * @param int $id the unique identity of role object
     * @param array $attributes role object attributes
     * @return bool true if modified, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Create a new role record
     *
     * @param int $id the unique identity of role object
     * @return bool true if deleted, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function delete(int $id): bool;
}
