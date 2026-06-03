<?php

namespace App\Repositories\Eloquents;

use App\Models\Compose;

class ComposeEloquent extends BaseEloquentRepository
{
    /**
     * Create the composition repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Compose::class);
    }
}
