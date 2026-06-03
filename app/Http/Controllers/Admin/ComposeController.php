<?php

namespace App\Http\Controllers\Admin;

use App\Services\ComposeService;

class ComposeController extends BaseApiCrudController
{
    /**
     * Create the composition controller.
     *
     * @param  ComposeService  $service  Composition service.
     * @return void
     */
    public function __construct(ComposeService $service)
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
        return 'composition';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'compositions';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'pavs_id' => ['required', 'integer', 'exists:pavs,id'],
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
            'pavs_id' => ['sometimes', 'integer', 'exists:pavs,id'],
            'ligne_id' => ['sometimes', 'integer', 'exists:lignes,id'],
        ];
    }
}
