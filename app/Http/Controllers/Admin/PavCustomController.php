<?php

namespace App\Http\Controllers\Admin;

use App\Services\PavCustomService;

class PavCustomController extends BaseApiCrudController
{
    /**
     * Create the custom PAV controller.
     *
     * @param  PavCustomService  $service  Custom PAV service.
     * @return void
     */
    public function __construct(PavCustomService $service)
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
        return 'pav_custom';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'pav_customs';
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
            'store_id' => ['required', 'integer', 'exists:stores,id'],
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
            'store_id' => ['sometimes', 'integer', 'exists:stores,id'],
        ];
    }
}
