<?php

namespace App\Services;

use App\Repositories\Eloquents\ReductionEloquent;

class ReductionService extends BaseCrudService
{
    /**
     * Create the discount service.
     *
     * @param  ReductionEloquent  $reductionRepository  Discount data repository.
     * @return void
     */
    public function __construct(ReductionEloquent $reductionRepository)
    {
        parent::__construct($reductionRepository);
    }
}
