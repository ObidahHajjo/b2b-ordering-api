<?php

namespace App\Http\Controllers\Admin;

use App\Services\ReductionGlobaleService;

class ReductionGlobaleController extends BaseApiCrudController
{
    /**
     * Create the global discount controller.
     *
     * @param  ReductionGlobaleService  $service  Global discount service.
     * @return void
     */
    public function __construct(ReductionGlobaleService $service)
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
        return 'reduction_globale';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'reductions_globales';
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
            'date_debut' => ['required', 'date'],
            'date_fin' => ['nullable', 'date', 'after_or_equal:date_debut'],
            'code' => ['nullable', 'string', 'max:10'],
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
            'date_debut' => ['sometimes', 'date'],
            'date_fin' => ['nullable', 'date'],
            'code' => ['nullable', 'string', 'max:10'],
        ];
    }
}
