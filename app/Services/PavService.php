<?php

namespace App\Services;

use App\Repositories\Eloquents\PavEloquent;

class PavService extends BaseCrudService
{
    /**
     * Create the PAV service.
     *
     * @param  PavEloquent  $pavRepository  PAV data repository.
     * @return void
     */
    public function __construct(PavEloquent $pavRepository)
    {
        parent::__construct($pavRepository);
    }
}
