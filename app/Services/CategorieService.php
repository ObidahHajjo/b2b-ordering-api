<?php

namespace App\Services;

use App\Repositories\Eloquents\CategorieEloquent;

class CategorieService extends BaseCrudService
{
    /**
     * Create the category service.
     *
     * @param  CategorieEloquent  $categorieRepository  Category data repository.
     * @return void
     */
    public function __construct(CategorieEloquent $categorieRepository)
    {
        parent::__construct($categorieRepository);
    }
}
