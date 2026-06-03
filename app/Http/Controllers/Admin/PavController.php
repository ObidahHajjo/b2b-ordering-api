<?php

namespace App\Http\Controllers\Admin;

use App\Services\PavService;

class PavController extends BaseApiCrudController
{
    /**
     * Create the PAV controller.
     *
     * @param  PavService  $service  PAV service.
     * @return void
     */
    public function __construct(PavService $service)
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
        return 'pav';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'pavs';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'nb_etage' => ['required', 'integer', 'min:1'],
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
            'nb_etage' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
