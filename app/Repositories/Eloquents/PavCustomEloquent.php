<?php

namespace App\Repositories\Eloquents;

use App\Models\PavCustom;

class PavCustomEloquent extends BaseEloquentRepository
{
    /**
     * Create the custom PAV repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(PavCustom::class);
    }
}
