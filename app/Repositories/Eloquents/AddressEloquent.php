<?php

namespace App\Repositories\Eloquents;

use App\Models\Address;

class AddressEloquent extends BaseEloquentRepository
{
    /**
     * Create the address repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(Address::class);
    }
}
