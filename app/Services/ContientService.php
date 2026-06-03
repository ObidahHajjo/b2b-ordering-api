<?php

namespace App\Services;

use App\Repositories\Eloquents\ContientEloquent;

class ContientService extends BaseCrudService
{
    /**
     * Create the level content service.
     *
     * @param  ContientEloquent  $contientRepository  Level content repository.
     * @return void
     */
    public function __construct(ContientEloquent $contientRepository)
    {
        parent::__construct($contientRepository);
    }
}
