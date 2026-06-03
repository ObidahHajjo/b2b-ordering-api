<?php

namespace App\Http\Controllers\Admin;

use App\Services\EtageService;

class EtageController extends BaseApiCrudController
{
    /**
     * Create the floor controller.
     *
     * @param  EtageService  $service  Floor service.
     * @return void
     */
    public function __construct(EtageService $service)
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
        return 'floor';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'floors';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'nom' => ['required', 'string', 'max:100'],
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
            'nom' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
