<?php

namespace App\Repositories\Eloquents;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseEloquentRepository implements BaseRepositoryInterface
{
    /**
     * Create the base repository.
     *
     * @param  class-string<Model>  $modelClass  Eloquent model class.
     * @return void
     */
    public function __construct(private readonly string $modelClass) {}

    /**
     * Get a model by id.
     *
     * @param  int|string  $id  Model primary key.
     * @return Model Found model.
     */
    public function getById(int|string $id): Model
    {
        return $this->query()->findOrFail($id);
    }

    /**
     * Get all models.
     *
     * @return Collection<int, Model> Model collection.
     */
    public function all(): Collection
    {
        return $this->query()->get();
    }

    /**
     * Create a model.
     *
     * @param  array<string, mixed>  $attributes  Model attributes.
     * @return Model Created model.
     */
    public function create(array $attributes): Model
    {
        return $this->query()->create($attributes);
    }

    /**
     * Update a model.
     *
     * @param  int|string  $id  Model primary key.
     * @param  array<string, mixed>  $attributes  Model attributes.
     * @return bool True when updated.
     */
    public function update(int|string $id, array $attributes): bool
    {
        return $this->getById($id)->update($attributes);
    }

    /**
     * Delete a model.
     *
     * @param  int|string  $id  Model primary key.
     * @return bool True when deleted.
     */
    public function delete(int|string $id): bool
    {
        return $this->getById($id)->delete();
    }

    /**
     * Create a model query.
     *
     * @return Builder<Model> Model query builder.
     */
    private function query(): Builder
    {
        return (new $this->modelClass)->newQuery();
    }
}
