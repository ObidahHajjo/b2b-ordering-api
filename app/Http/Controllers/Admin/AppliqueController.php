<?php

namespace App\Http\Controllers\Admin;

use App\Services\AppliqueService;

class AppliqueController extends BaseApiCrudController
{
    /**
     * Create the discount application controller.
     *
     * @param  AppliqueService  $service  Discount application service.
     * @return void
     */
    public function __construct(AppliqueService $service)
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
        return 'application';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'applications';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'reduction_id' => ['required', 'integer', 'exists:reductions,id'],
            'ligne_id' => ['nullable', 'integer', 'exists:lignes,id', 'required_without:pavs_id'],
            'pavs_id' => ['nullable', 'integer', 'exists:pavs,id', 'required_without:ligne_id'],
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
            'reduction_id' => ['sometimes', 'integer', 'exists:reductions,id'],
            'ligne_id' => ['nullable', 'integer', 'exists:lignes,id'],
            'pavs_id' => ['nullable', 'integer', 'exists:pavs,id'],
        ];
    }
}
