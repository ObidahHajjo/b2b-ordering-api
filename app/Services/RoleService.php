<?php

namespace App\Services;

use App\Repositories\Eloquents\RoleEloquent;
use App\Exceptions\MissingAttributesException;
use App\Interfaces\RoleInterface;
use App\Models\Role;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;

class RoleService implements RoleInterface
{
    private RoleEloquent $roleEloquent;

    public function __construct(RoleEloquent $roleEloquent)
    {
        $this->roleEloquent = $roleEloquent;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $id): ?Role
    {
        if(empty($id)) return null;
        try{
            return $this->roleEloquent->getById($id);
        }catch (ModelNotFoundException){
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function getByName(string $name): ?Role
    {
        if (empty($name) || trim($name) == '') return null;
        try {
            return $this->roleEloquent->getByName($name);
        } catch (ModelNotFoundException) {
            return null;
        }
    }

    /**
     * @inheritDoc
     */
    public function all(): Collection
    {
        return $this->roleEloquent->all();
    }

    /**
     * @inheritDoc
     */
    public function create(array $attributes): Role
    {
        if (!array_key_exists('name', $attributes)) throw new MissingAttributesException(['name']);
        return $this->roleEloquent->create($attributes);
    }

    /**
     * @inheritDoc
     */
    public function update(int $id, array $attributes): bool
    {
        if(empty($id)) return false;
        try{
            return $this->roleEloquent->update($id, $attributes);
        }catch (ModelNotFoundException){
            return false;
        }
    }

    /**
     * @inheritDoc
     */
    public function delete(int $id): bool
    {
        if(empty($id)) return false;
        try{
            return $this->roleEloquent->delete($id);
        }catch (ModelNotFoundException){
            return false;
        }
    }
}
