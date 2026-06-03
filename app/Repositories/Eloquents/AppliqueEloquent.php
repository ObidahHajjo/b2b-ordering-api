<?php

namespace App\Repositories\Eloquents;

use App\Models\Applique;

class AppliqueEloquent extends BaseEloquentRepository
{
    /**
     * Create the application repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Applique::class);
    }
}
