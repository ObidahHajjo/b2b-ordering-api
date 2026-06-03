<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\Categories\StoreCategoryRequest;
use App\Http\Requests\Admin\Categories\UpdateCategoryRequest;
use App\Http\Resources\Admin\CategoryResource;
use App\Services\CategorieService;

class CategorieController extends BaseApiCrudController
{
    /**
     * Create the category controller.
     *
     * @param  CategorieService  $service  Category service.
     * @return void
     */
    public function __construct(CategorieService $service)
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
        return 'category';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'categories';
    }

    protected function storeRules(): array
    {
        return [
            'libelle' => ['required', 'string', 'max:50'],
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
            'libelle' => ['sometimes', 'string', 'max:50'],
        ];
    }

    /**
     * Get the category resource class.
     *
     * @return class-string<CategoryResource> Resource class name.
     */
    protected function resourceClass(): ?string
    {
        return CategoryResource::class;
    }

    /**
     * Get the category store request class.
     *
     * @return class-string<StoreCategoryRequest> Request class name.
     */
    protected function storeRequestClass(): ?string
    {
        return StoreCategoryRequest::class;
    }

    /**
     * Get the category update request class.
     *
     * @return class-string<UpdateCategoryRequest> Request class name.
     */
    protected function updateRequestClass(): ?string
    {
        return UpdateCategoryRequest::class;
    }
}
