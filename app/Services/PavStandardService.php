<?php

namespace App\Services;

use App\Repositories\Eloquents\PavStandardEloquent;

class PavStandardService extends BaseCrudService
{
    /**
     * Create the standard PAV service.
     *
     * @param  PavStandardEloquent  $pavStandardRepository  Standard PAV repository.
     * @return void
     */
    public function __construct(PavStandardEloquent $pavStandardRepository)
    {
        parent::__construct($pavStandardRepository);
    }
}
