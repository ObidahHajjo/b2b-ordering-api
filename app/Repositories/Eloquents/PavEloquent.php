<?php

namespace App\Repositories\Eloquents;

use App\Models\Pav;

class PavEloquent extends BaseEloquentRepository
{
    /**
     * Create the PAV repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Pav::class);
    }
}
