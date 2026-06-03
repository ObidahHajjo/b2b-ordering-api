<?php

namespace App\Services;

use App\Repositories\Eloquents\ReductionPersonnelEloquent;

class ReductionPersonnelService extends BaseCrudService
{
    /**
     * Create the personal discount service.
     *
     * @param  ReductionPersonnelEloquent  $reductionPersonnelRepository  Personal discount repository.
     * @return void
     */
    public function __construct(ReductionPersonnelEloquent $reductionPersonnelRepository)
    {
        parent::__construct($reductionPersonnelRepository);
    }
}
