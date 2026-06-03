<?php

namespace App\Http\Controllers\Admin;

use App\Services\InclutService;

class InclutController extends BaseApiCrudController
{
    /**
     * Create the inclusion controller.
     *
     * @param  InclutService  $service  Inclusion service.
     * @return void
     */
    public function __construct(InclutService $service)
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
        return 'inclusion';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'inclusions';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'commande_numero' => ['required', 'integer', 'exists:commandes,numero'],
            'pavs_id' => ['required', 'integer', 'exists:pavs,id'],
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
            'commande_numero' => ['sometimes', 'integer', 'exists:commandes,numero'],
            'pavs_id' => ['sometimes', 'integer', 'exists:pavs,id'],
        ];
    }
}
