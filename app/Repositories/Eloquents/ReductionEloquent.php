<?php

namespace App\Repositories\Eloquents;

use App\Models\Reduction;

class ReductionEloquent extends BaseEloquentRepository
{
    /**
     * Create the discount repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Reduction::class);
    }
}
