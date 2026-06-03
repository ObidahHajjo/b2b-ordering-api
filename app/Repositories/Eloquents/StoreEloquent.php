<?php

namespace App\Repositories\Eloquents;

use App\Models\Store;
use App\Repositories\Interfaces\StoreInterface;
use Illuminate\Support\Collection;

class StoreEloquent implements StoreInterface
{
    /**
     * Get a store by id.
     *
     * @param  int  $id  Store id.
     * @return Store Found store.
     */
    public function getById(int $id): Store
    {
        return Store::findOrFail($id);
    }

    /**
     * Get all stores.
     *
     * @return Collection<int, Store> Store collection.
     */
    public function all(): Collection
    {
        return Store::all();
    }

    /**
     * Create a store.
     *
     * @param  array<string, mixed>  $attributes  Store attributes.
     * @return Store Created store.
     */
    public function create(array $attributes): Store
    {
        return Store::create($attributes);
    }

    /**
     * Update a store.
     *
     * @param  int  $id  Store id.
     * @param  array<string, mixed>  $attributes  Store attributes.
     * @return bool True when updated.
     */
    public function update(int $id, array $attributes): bool
    {
        return Store::findOrFail($id)->update($attributes);
    }

    /**
     * Delete a store.
     *
     * @param  int  $id  Store id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        return Store::findOrFail($id)->delete();
    }
}
