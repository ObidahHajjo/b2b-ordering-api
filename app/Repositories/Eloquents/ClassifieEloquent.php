<?php

namespace App\Repositories\Eloquents;

use App\Models\Classifie;

class ClassifieEloquent extends BaseEloquentRepository
{
    /**
     * Create the classification repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Classifie::class);
    }
}
