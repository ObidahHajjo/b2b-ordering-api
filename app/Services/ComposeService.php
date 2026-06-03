<?php

namespace App\Services;

use App\Repositories\Eloquents\ComposeEloquent;

class ComposeService extends BaseCrudService
{
    /**
     * Create the invoice composition service.
     *
     * @param  ComposeEloquent  $composeRepository  Invoice composition repository.
     * @return void
     */
    public function __construct(ComposeEloquent $composeRepository)
    {
        parent::__construct($composeRepository);
    }
}
