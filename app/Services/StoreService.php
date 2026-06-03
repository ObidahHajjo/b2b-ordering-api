<?php

namespace App\Services;

use App\Exceptions\MissingAttributesException;
use App\Models\Store;
use App\Repositories\Interfaces\StoreInterface as StoreRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class StoreService
{
    /**
     * Create the store service.
     *
     * @param  StoreRepository  $storeRepository  Store data repository.
     * @return void
     */
    public function __construct(private readonly StoreRepository $storeRepository) {}

    /**
     * Get a store by id.
     *
     * @param  int  $id  Store id.
     * @return Store|null Found store.
     */
    public function getById(int $id): ?Store
    {
        if (empty($id)) {
            return null;
        }

        try {
            return $this->storeRepository->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get all stores.
     *
     * @return Collection<int, Store> Store collection.
     */
    public function all(): Collection
    {
        return $this->storeRepository->all();
    }

    /**
     * Create a store.
     *
     * @param  array<string, mixed>  $attributes  Store attributes.
     * @return Store Created store.
     *
     * @throws MissingAttributesException When required attributes are missing.
     */
    public function create(array $attributes): Store
    {
        if (! array_key_exists('name', $attributes)) {
            throw new MissingAttributesException(['name']);
        }

        return $this->storeRepository->create($attributes);
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
        if (empty($id)) {
            return false;
        }

        try {
            return $this->storeRepository->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * Delete a store.
     *
     * @param  int  $id  Store id.
     * @return bool True when deleted.
     */
    public function delete(int $id): bool
    {
        if (empty($id)) {
            return false;
        }

        try {
            return $this->storeRepository->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
