<?php

namespace App\Http\Controllers\Admin;

use App\Services\CommandeService;

class CommandeController extends BaseApiCrudController
{
    /**
     * Create the order controller.
     *
     * @param  CommandeService  $service  Order service.
     * @return void
     */
    public function __construct(CommandeService $service)
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
        return 'order';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'orders';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'numero' => ['required', 'integer', 'min:1'],
            'date_creation' => ['required', 'date'],
            'date_validation' => ['nullable', 'date'],
            'statut' => ['required', 'in:en_attente,validee,annulee,facturee'],
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
            'numero' => ['sometimes', 'integer', 'min:1'],
            'date_creation' => ['sometimes', 'date'],
            'date_validation' => ['nullable', 'date'],
            'statut' => ['sometimes', 'in:en_attente,validee,annulee,facturee'],
        ];
    }
}
