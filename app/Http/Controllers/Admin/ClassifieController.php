<?php

namespace App\Http\Controllers\Admin;

use App\Services\ClassifieService;

class ClassifieController extends BaseApiCrudController
{
    /**
     * Create the classification controller.
     *
     * @param  ClassifieService  $service  Classification service.
     * @return void
     */
    public function __construct(ClassifieService $service)
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
        return 'classification';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'classifications';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'produit_ref' => ['required', 'string', 'exists:produits,ref'],
            'categorie_id' => ['required', 'integer', 'exists:categories,id'],
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
            'produit_ref' => ['sometimes', 'string', 'exists:produits,ref'],
            'categorie_id' => ['sometimes', 'integer', 'exists:categories,id'],
        ];
    }
}
