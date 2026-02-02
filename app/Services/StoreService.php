<?php

namespace App\Services;

use App\Repositories\Interfaces\StoreInterface as StoreRepoInterface;
use App\Exceptions\MissingAttributesException;
use App\Interfaces\StoreInterface;
use App\Models\Store;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class StoreService implements StoreInterface
{
    private StoreRepoInterface $storeEloquent;

    public function __construct(StoreRepoInterface $storeEloquent)
    {
        $this->storeEloquent = $storeEloquent;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Store
    {
        if (empty($id)) return null;

        try {
            return $this->storeEloquent->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->storeEloquent->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Store
    {
        if (!array_key_exists('name', $attributes)) {
            throw new MissingAttributesException(['name']);
        }

        return $this->storeEloquent->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        if (empty($id)) return false;

        try {
            return $this->storeEloquent->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if (empty($id)) return false;

        try {
            return $this->storeEloquent->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
