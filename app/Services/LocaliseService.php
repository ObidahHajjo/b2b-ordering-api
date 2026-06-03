<?php

namespace App\Services;

use App\Repositories\Eloquents\LocaliseEloquent;

class LocaliseService extends BaseCrudService
{
    /**
     * Create the product location service.
     *
     * @param  LocaliseEloquent  $localiseRepository  Product location repository.
     * @return void
     */
    public function __construct(LocaliseEloquent $localiseRepository)
    {
        parent::__construct($localiseRepository);
    }
}
