<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Products\StoreProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;
use App\Http\Resources\Admin\ProductResource;
use App\Services\ProduitService;

class ProduitController extends BaseApiCrudController
{
    /**
     * Create the product controller.
     *
     * @param  ProduitService  $service  Product service.
     * @return void
     */
    public function __construct(ProduitService $service)
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
        return 'product';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'products';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'ref' => ['required', 'string', 'max:6'],
            'nom' => ['required', 'string', 'max:50'],
            'prix' => ['required', 'numeric', 'min:0'],
            'poids' => ['required', 'numeric', 'min:0'],
            'liste_ingredient' => ['nullable', 'string'],
            'est_disponible' => ['sometimes', 'boolean'],
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
            'ref' => ['sometimes', 'string', 'max:6'],
            'nom' => ['sometimes', 'string', 'max:50'],
            'prix' => ['sometimes', 'numeric', 'min:0'],
            'poids' => ['sometimes', 'numeric', 'min:0'],
            'liste_ingredient' => ['nullable', 'string'],
            'est_disponible' => ['sometimes', 'boolean'],
        ];
    }

    /**
     * Get the product resource class.
     *
     * @return class-string<ProductResource> Resource class name.
     */
    protected function resourceClass(): ?string
    {
        return ProductResource::class;
    }

    /**
     * Get the product store request class.
     *
     * @return class-string<StoreProductRequest> Request class name.
     */
    protected function storeRequestClass(): ?string
    {
        return StoreProductRequest::class;
    }

    /**
     * Get the product update request class.
     *
     * @return class-string<UpdateProductRequest> Request class name.
     */
    protected function updateRequestClass(): ?string
    {
        return UpdateProductRequest::class;
    }
}
