<?php

namespace App\Services;

use App\Repositories\Eloquents\ClassifieEloquent;

class ClassifieService extends BaseCrudService
{
    /**
     * Create the classification service.
     *
     * @param  ClassifieEloquent  $classifieRepository  Classification data repository.
     * @return void
     */
    public function __construct(ClassifieEloquent $classifieRepository)
    {
        parent::__construct($classifieRepository);
    }
}
