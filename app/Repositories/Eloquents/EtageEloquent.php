<?php

namespace App\Repositories\Eloquents;

use App\Models\Etage;

class EtageEloquent extends BaseEloquentRepository
{
    /**
     * Create the floor repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Etage::class);
    }
}
