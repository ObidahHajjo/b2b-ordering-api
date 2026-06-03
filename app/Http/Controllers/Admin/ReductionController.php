<?php

namespace App\Http\Controllers\Admin;

use App\Services\ReductionService;

class ReductionController extends BaseApiCrudController
{
    /**
     * Create the discount controller.
     *
     * @param  ReductionService  $service  Discount service.
     * @return void
     */
    public function __construct(ReductionService $service)
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
        return 'reduction';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'reductions';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'taux' => ['required', 'string', 'max:50'],
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
            'taux' => ['sometimes', 'string', 'max:50'],
        ];
    }
}
