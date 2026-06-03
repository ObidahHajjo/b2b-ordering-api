<?php

namespace App\Repositories\Eloquents;

use App\Models\Contient;

class ContientEloquent extends BaseEloquentRepository
{
    /**
     * Create the PAV floor repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Contient::class);
    }
}
