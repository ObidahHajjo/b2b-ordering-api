<?php

namespace App\Services;

use App\Repositories\Eloquents\AppliqueEloquent;

class AppliqueService extends BaseCrudService
{
    /**
     * Create the discount application service.
     *
     * @param  AppliqueEloquent  $appliqueRepository  Discount application repository.
     * @return void
     */
    public function __construct(AppliqueEloquent $appliqueRepository)
    {
        parent::__construct($appliqueRepository);
    }
}
