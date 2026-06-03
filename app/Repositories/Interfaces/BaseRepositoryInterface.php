<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface BaseRepositoryInterface
{
    /**
     * Get a model by id.
     *
     * @param  int|string  $id  Model primary key.
     * @return Model Found model.
     */
    public function getById(int|string $id): Model;

    /**
     * Get all models.
     *
     * @return Collection<int, Model> Model collection.
     */
    public function all(): Collection;

    /**
     * Create a model.
     *
     * @param  array<string, mixed>  $attributes  Model attributes.
     * @return Model Created model.
     */
    public function create(array $attributes): Model;

    /**
     * Update a model.
     *
     * @param  int|string  $id  Model primary key.
     * @param  array<string, mixed>  $attributes  Model attributes.
     * @return bool True when updated.
     */
    public function update(int|string $id, array $attributes): bool;

    /**
     * Delete a model.
     *
     * @param  int|string  $id  Model primary key.
     * @return bool True when deleted.
     */
    public function delete(int|string $id): bool;
}
