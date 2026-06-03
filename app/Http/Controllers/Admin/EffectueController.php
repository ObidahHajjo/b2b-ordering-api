<?php

namespace App\Http\Controllers\Admin;

use App\Services\EffectueService;

class EffectueController extends BaseApiCrudController
{
    /**
     * Create the execution controller.
     *
     * @param  EffectueService  $service  Execution service.
     * @return void
     */
    public function __construct(EffectueService $service)
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
        return 'execution';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'executions';
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
            'user_id' => ['required', 'integer', 'exists:users,id'],
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
            'user_id' => ['sometimes', 'integer', 'exists:users,id'],
        ];
    }
}
