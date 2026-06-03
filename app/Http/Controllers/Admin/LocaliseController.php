<?php

namespace App\Http\Controllers\Admin;

use App\Services\LocaliseService;

class LocaliseController extends BaseApiCrudController
{
    /**
     * Create the location controller.
     *
     * @param  LocaliseService  $service  Location service.
     * @return void
     */
    public function __construct(LocaliseService $service)
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
        return 'location';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'locations';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'etage_id' => ['required', 'integer', 'exists:etages,id'],
            'produit_ref' => ['required', 'string', 'exists:produits,ref'],
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
            'etage_id' => ['sometimes', 'integer', 'exists:etages,id'],
            'produit_ref' => ['sometimes', 'string', 'exists:produits,ref'],
        ];
    }
}
