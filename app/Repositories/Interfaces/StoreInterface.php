<?php

namespace App\Repositories\Interfaces;

use App\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

interface StoreInterface
{

    /**
     * Get a store by his id
     *
     * @param int $id store unique identity
     * @return Store Store object
     * @throws ModelNotFoundException if no record found
     */
    public function getById(int $id) : Store;

    /**
     * Get all stores
     *
     * @return Collection an array with all the stores
     */
    public function all() : Collection;

    /**
     * Create a new store record
     *
     * @param array $attributes store object attributes
     * @return Store the created Store object
     */
    public function create(array $attributes): Store;

    /**
     * Create a new store record
     *
     * @param int $id the unique identity of store object
     * @param array $attributes store object attributes
     * @return bool true if modified, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function update(int $id, array $attributes): bool;

    /**
     * Create a new store record
     *
     * @param int $id the unique identity of store object
     * @return bool true if deleted, false if not
     * @throws ModelNotFoundException if no record found
     */
    public function delete(int $id): bool;
}
