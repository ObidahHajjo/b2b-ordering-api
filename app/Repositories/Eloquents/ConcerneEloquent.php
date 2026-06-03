<?php

namespace App\Repositories\Eloquents;

use App\Models\Concerne;

class ConcerneEloquent extends BaseEloquentRepository
{
    /**
     * Create the invoice line repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Concerne::class);
    }
}
