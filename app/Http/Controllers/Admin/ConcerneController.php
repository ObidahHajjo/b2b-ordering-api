<?php

namespace App\Http\Controllers\Admin;

use App\Services\ConcerneService;

class ConcerneController extends BaseApiCrudController
{
    /**
     * Create the concern controller.
     *
     * @param  ConcerneService  $service  Concern service.
     * @return void
     */
    public function __construct(ConcerneService $service)
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
        return 'concern';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'concerns';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'facture_id' => ['required', 'integer', 'exists:factures,id'],
            'ligne_id' => ['required', 'integer', 'exists:lignes,id'],
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
            'facture_id' => ['sometimes', 'integer', 'exists:factures,id'],
            'ligne_id' => ['sometimes', 'integer', 'exists:lignes,id'],
        ];
    }
}
