<?php

namespace App\Services;

use App\Repositories\Eloquents\AddressEloquent;

class AddressService extends BaseCrudService
{
    /**
     * Create the address service.
     *
     * @param  AddressEloquent  $addressRepository  Address data repository.
     * @return void
     */
    public function __construct(AddressEloquent $addressRepository)
    {
        parent::__construct($addressRepository);
    }
}
