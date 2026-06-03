<?php

namespace App\Services;

use App\Repositories\Eloquents\ReductionGlobaleEloquent;

class ReductionGlobaleService extends BaseCrudService
{
    /**
     * Create the global discount service.
     *
     * @param  ReductionGlobaleEloquent  $reductionGlobaleRepository  Global discount repository.
     * @return void
     */
    public function __construct(ReductionGlobaleEloquent $reductionGlobaleRepository)
    {
        parent::__construct($reductionGlobaleRepository);
    }
}
