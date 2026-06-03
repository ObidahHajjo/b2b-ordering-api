<?php

namespace App\Repositories\Eloquents;

use App\Models\ReductionGlobale;

class ReductionGlobaleEloquent extends BaseEloquentRepository
{
    /**
     * Create the global discount repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(ReductionGlobale::class);
    }
}
