<?php

namespace App\Repositories\Eloquents;

use App\Models\Produit;

class ProduitEloquent extends BaseEloquentRepository
{
    /**
     * Create the product repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Produit::class);
    }
}
