<?php

namespace App\Repositories\Eloquents;

use App\Models\Localise;

class LocaliseEloquent extends BaseEloquentRepository
{
    /**
     * Create the product location repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Localise::class);
    }
}
