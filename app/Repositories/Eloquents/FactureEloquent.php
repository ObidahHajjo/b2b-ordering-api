<?php

namespace App\Repositories\Eloquents;

use App\Models\Facture;

class FactureEloquent extends BaseEloquentRepository
{
    /**
     * Create the invoice repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Facture::class);
    }
}
