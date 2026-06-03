<?php

namespace App\Http\Controllers\Admin;

use App\Services\AddressService;

class AddressController extends BaseApiCrudController
{
    /**
     * Create the address controller.
     *
     * @param  AddressService  $service  Address service.
     * @return void
     */
    public function __construct(AddressService $service)
    {
        parent::__construct($service);
    }

    /**
     * Get the singular resource key.
     *
     * @return string Singular response key.
     */
    protected function resourceKey(): string
    {
        return 'address';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'addresses';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'city' => ['required', 'string', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'number' => ['required', 'string', 'max:50'],
            'postal_code' => ['required', 'string', 'max:20'],
        ];
    }

    /**
     * Get update validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function updateRules(): array
    {
        return [
            'city' => ['sometimes', 'string', 'max:255'],
            'street' => ['sometimes', 'string', 'max:255'],
            'number' => ['sometimes', 'string', 'max:50'],
            'postal_code' => ['sometimes', 'string', 'max:20'],
        ];
    }
}
