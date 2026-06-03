<?php

namespace App\Repositories\Eloquents;

use App\Models\Ligne;

class LigneEloquent extends BaseEloquentRepository
{
    /**
     * Create the line repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Ligne::class);
    }
}
