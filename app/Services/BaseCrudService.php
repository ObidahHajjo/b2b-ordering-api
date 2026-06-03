<?php

namespace App\Services;

use App\Repositories\Interfaces\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class BaseCrudService
{
    /**
     * Create the base CRUD service.
     *
     * @param  BaseRepositoryInterface  $repository  Data repository.
     * @return void
     */
    public function __construct(private readonly BaseRepositoryInterface $repository) {}

    /**
     * Get a model by id.
     *
     * @param  int|string  $id  Model primary key.
     * @return Model|null Found model.
     */
    public function getById(int|string $id): ?Model
    {
        if ($id === '' || $id === 0) {
            return null;
        }

        try {
            return $this->repository->getById($id);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * Get all models.
     *
     * @return Collection<int, Model> Model collection.
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * Create a model.
     *
     * @param  array<string, mixed>  $attributes  Model attributes.
     * @return Model Created model.
     */
    public function create(array $attributes): Model
    {
        return $this->repository->create($attributes);
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
        if (($id === '' || $id === 0) || $attributes === []) {
            return false;
        }

        try {
            return $this->repository->update($id, $attributes);
        } catch (ModelNotFoundException) {
            return false;
        }
    }

    /**
     * Delete a model.
     *
     * @param  int|string  $id  Model primary key.
     * @return bool True when deleted.
     */
    public function delete(int|string $id): bool
    {
        if ($id === '' || $id === 0) {
            return false;
        }

        try {
            return $this->repository->delete($id);
        } catch (ModelNotFoundException) {
            return false;
        }
    }
}
