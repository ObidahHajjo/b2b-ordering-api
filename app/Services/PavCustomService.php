<?php

namespace App\Services;

use App\Repositories\Eloquents\PavCustomEloquent;

class PavCustomService extends BaseCrudService
{
    /**
     * Create the custom PAV service.
     *
     * @param  PavCustomEloquent  $pavCustomRepository  Custom PAV repository.
     * @return void
     */
    public function __construct(PavCustomEloquent $pavCustomRepository)
    {
        parent::__construct($pavCustomRepository);
    }
}
