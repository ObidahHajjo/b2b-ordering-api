<?php

namespace App\Services;

use App\Repositories\Eloquents\ProduitEloquent;

class ProduitService extends BaseCrudService
{
    /**
     * Create the product service.
     *
     * @param  ProduitEloquent  $produitRepository  Product data repository.
     * @return void
     */
    public function __construct(ProduitEloquent $produitRepository)
    {
        parent::__construct($produitRepository);
    }
}
