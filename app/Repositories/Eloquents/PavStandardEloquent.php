<?php

namespace App\Repositories\Eloquents;

use App\Models\PavStandard;

class PavStandardEloquent extends BaseEloquentRepository
{
    /**
     * Create the standard PAV repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(PavStandard::class);
    }
}
