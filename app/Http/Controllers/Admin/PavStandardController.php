<?php

namespace App\Http\Controllers\Admin;

use App\Services\PavStandardService;

class PavStandardController extends BaseApiCrudController
{
    /**
     * Create the standard PAV controller.
     *
     * @param  PavStandardService  $service  Standard PAV service.
     * @return void
     */
    public function __construct(PavStandardService $service)
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
        return 'pav_standard';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'pav_standards';
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
            'nom' => ['required', 'string', 'max:100'],
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
            'nom' => ['sometimes', 'string', 'max:100'],
        ];
    }
}
