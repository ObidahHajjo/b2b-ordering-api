<?php

namespace App\Services;

use App\Repositories\Eloquents\EtageEloquent;

class EtageService extends BaseCrudService
{
    /**
     * Create the floor service.
     *
     * @param  EtageEloquent  $etageRepository  Floor data repository.
     * @return void
     */
    public function __construct(EtageEloquent $etageRepository)
    {
        parent::__construct($etageRepository);
    }
}
