<?php

namespace App\Repositories\Eloquents;

use App\Models\Effectue;

class EffectueEloquent extends BaseEloquentRepository
{
    /**
     * Create the user order repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Effectue::class);
    }
}
