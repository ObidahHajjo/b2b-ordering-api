<?php

namespace App\Services;

use App\Repositories\Eloquents\CommandeEloquent;

class CommandeService extends BaseCrudService
{
    /**
     * Create the order service.
     *
     * @param  CommandeEloquent  $commandeRepository  Order data repository.
     * @return void
     */
    public function __construct(CommandeEloquent $commandeRepository)
    {
        parent::__construct($commandeRepository);
    }
}
