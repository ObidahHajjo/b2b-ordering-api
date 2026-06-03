<?php

namespace App\Services;

use App\Repositories\Eloquents\LigneEloquent;

class LigneService extends BaseCrudService
{
    /**
     * Create the order line service.
     *
     * @param  LigneEloquent  $ligneRepository  Order line repository.
     * @return void
     */
    public function __construct(LigneEloquent $ligneRepository)
    {
        parent::__construct($ligneRepository);
    }
}
