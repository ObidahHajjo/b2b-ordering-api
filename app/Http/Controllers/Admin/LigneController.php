<?php

namespace App\Http\Controllers\Admin;

use App\Services\LigneService;

class LigneController extends BaseApiCrudController
{
    /**
     * Create the line controller.
     *
     * @param  LigneService  $service  Line service.
     * @return void
     */
    public function __construct(LigneService $service)
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
        return 'line';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'lines';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'prix_unitaire' => ['required', 'numeric', 'min:0'],
            'qte' => ['required', 'integer', 'min:1'],
            'produit_ref' => ['required', 'string', 'exists:produits,ref'],
            'commande_numero' => ['required', 'integer', 'exists:commandes,numero'],
            'reduction_id' => ['nullable', 'integer', 'exists:reductions,id'],
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
            'prix_unitaire' => ['sometimes', 'numeric', 'min:0'],
            'qte' => ['sometimes', 'integer', 'min:1'],
            'produit_ref' => ['sometimes', 'string', 'exists:produits,ref'],
            'commande_numero' => ['sometimes', 'integer', 'exists:commandes,numero'],
            'reduction_id' => ['nullable', 'integer', 'exists:reductions,id'],
        ];
    }
}
