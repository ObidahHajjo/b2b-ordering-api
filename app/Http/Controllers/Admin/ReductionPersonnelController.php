<?php

namespace App\Http\Controllers\Admin;

use App\Services\ReductionPersonnelService;

class ReductionPersonnelController extends BaseApiCrudController
{
    /**
     * Create the personal discount controller.
     *
     * @param  ReductionPersonnelService  $service  Personal discount service.
     * @return void
     */
    public function __construct(ReductionPersonnelService $service)
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
        return 'reduction_personnelle';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'reductions_personnelles';
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
            'date_application' => ['required', 'date'],
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
            'date_application' => ['sometimes', 'date'],
        ];
    }
}
