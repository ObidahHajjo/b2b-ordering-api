<?php

namespace App\Repositories\Eloquents;

use App\Models\ReductionPersonnel;

class ReductionPersonnelEloquent extends BaseEloquentRepository
{
    /**
     * Create the personnel discount repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ReductionPersonnel::class);
    }
}
