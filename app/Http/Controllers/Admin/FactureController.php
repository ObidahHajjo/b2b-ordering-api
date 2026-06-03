<?php

namespace App\Http\Controllers\Admin;

use App\Services\FactureService;

class FactureController extends BaseApiCrudController
{
    /**
     * Create the invoice controller.
     *
     * @param  FactureService  $service  Invoice service.
     * @return void
     */
    public function __construct(FactureService $service)
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
        return 'facture';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'factures';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'date_facturation' => ['required', 'date'],
            'statut' => ['required', 'in:brouillon,emise,payee,annulee'],
            'fdp' => ['required', 'numeric', 'min:0'],
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
            'date_facturation' => ['sometimes', 'date'],
            'statut' => ['sometimes', 'in:brouillon,emise,payee,annulee'],
            'fdp' => ['sometimes', 'numeric', 'min:0'],
            'commande_numero' => ['sometimes', 'integer', 'exists:commandes,numero'],
            'reduction_id' => ['nullable', 'integer', 'exists:reductions,id'],
        ];
    }
}
