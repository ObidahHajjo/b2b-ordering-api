<?php

namespace App\Services;

use App\Repositories\Eloquents\FactureEloquent;

class FactureService extends BaseCrudService
{
    /**
     * Create the invoice service.
     *
     * @param  FactureEloquent  $factureRepository  Invoice data repository.
     * @return void
     */
    public function __construct(FactureEloquent $factureRepository)
    {
        parent::__construct($factureRepository);
    }
}
