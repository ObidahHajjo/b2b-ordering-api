<?php

namespace App\Http\Controllers\Admin;

use App\Services\FileService;

class FileController extends BaseApiCrudController
{
    /**
     * Create the file controller.
     *
     * @param  FileService  $service  File service.
     * @return void
     */
    public function __construct(FileService $service)
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
        return 'file';
    }

    /**
     * Get the collection response key.
     *
     * @return string Collection response key.
     */
    protected function collectionKey(): string
    {
        return 'files';
    }

    /**
     * Get creation validation rules.
     *
     * @return array<string, mixed> Validation rules.
     */
    protected function storeRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'path' => ['required', 'string', 'max:255'],
            'uploaded_at' => ['required', 'date'],
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
            'name' => ['sometimes', 'string', 'max:255'],
            'path' => ['sometimes', 'string', 'max:255'],
            'uploaded_at' => ['sometimes', 'date'],
            'store_id' => ['sometimes', 'integer', 'exists:stores,id'],
        ];
    }
}
