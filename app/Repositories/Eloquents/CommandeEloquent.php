<?php

namespace App\Repositories\Eloquents;

use App\Models\Commande;

class CommandeEloquent extends BaseEloquentRepository
{
    /**
     * Create the order repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Commande::class);
    }
}
