<?php

namespace App\Http\Controllers\Admin;

use App\Services\ContientService;

class ContientController extends BaseApiCrudController
{
    /**
     * Create the content controller.
     *
     * @param  ContientService  $service  Content service.
     * @return void
     */
    public function __construct(ContientService $service)
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
        return 'content';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'contents';
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
            'etage_id' => ['required', 'integer', 'exists:etages,id'],
            'qte' => ['required', 'integer', 'min:1'],
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
            'etage_id' => ['sometimes', 'integer', 'exists:etages,id'],
            'qte' => ['sometimes', 'integer', 'min:1'],
        ];
    }
}
