<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\StoreInterface;
use App\Models\Store;
use Illuminate\Support\Collection;

class StoreEloquent implements StoreInterface
{

    /**
     * @inheritDoc
     */
    public function getById(int $id): Store
    {
        return Store::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return Store::all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Store
    {
        return Store::create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        return Store::find($id)->update($attributes);
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        return Store::find($id)->delete();
    }
}
