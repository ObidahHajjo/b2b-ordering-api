<?php

namespace App\Repositories\Eloquents;

use App\Models\Categorie;

class CategorieEloquent extends BaseEloquentRepository
{
    /**
     * Create the category repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Categorie::class);
    }
}
