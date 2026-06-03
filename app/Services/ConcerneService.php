<?php

namespace App\Services;

use App\Repositories\Eloquents\ConcerneEloquent;

class ConcerneService extends BaseCrudService
{
    /**
     * Create the global discount service.
     *
     * @param  ConcerneEloquent  $concerneRepository  Global discount repository.
     * @return void
     */
    public function __construct(ConcerneEloquent $concerneRepository)
    {
        parent::__construct($concerneRepository);
    }
}
