<?php

namespace App\Repositories\Eloquents;

use App\Models\Inclut;

class InclutEloquent extends BaseEloquentRepository
{
    /**
     * Create the order PAV repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Inclut::class);
    }
}
