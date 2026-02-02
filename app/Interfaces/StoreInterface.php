<?php

namespace App\Interfaces;

use App\Exceptions\MissingAttributesException;
use App\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface StoreInterface
{
    /**
     * Get a store by its id
     *
     * @param int $id store unique identity
     * @return Store|null Store object, or null if not found
     */
    public function getById(int $id): ?Store;

    /**
     * Get all stores
     *
     * @return Collection an array with all the stores, or empty array
     */
    public function all(): Collection;

    /**
     * Create a new store instance
     *
     * @param array $attributes The store attributes
     * @return Store new Store object
     * @throws MissingAttributesException if some attributes are missed
     */
    public function create(array $attributes): Store;

    /**
     * Update an existing store instance
     *
     * @param int $id
     * @param array $attributes The store attributes
     * @return bool true if modified successfully, false if not
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Delete an existing store instance
     *
     * @param int $id
     * @return bool true if deleted successfully, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function delete(int $id): bool;
}
