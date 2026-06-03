<?php

namespace App\Services;

use App\Repositories\Eloquents\InclutEloquent;

class InclutService extends BaseCrudService
{
    /**
     * Create the invoice line service.
     *
     * @param  InclutEloquent  $inclutRepository  Invoice line repository.
     * @return void
     */
    public function __construct(InclutEloquent $inclutRepository)
    {
        parent::__construct($inclutRepository);
    }
}
