<?php

namespace App\Services;

use App\Repositories\Eloquents\EffectueEloquent;

class EffectueService extends BaseCrudService
{
    /**
     * Create the order execution service.
     *
     * @param  EffectueEloquent  $effectueRepository  Order execution repository.
     * @return void
     */
    public function __construct(EffectueEloquent $effectueRepository)
    {
        parent::__construct($effectueRepository);
    }
}
