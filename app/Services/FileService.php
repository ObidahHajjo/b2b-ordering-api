<?php

namespace App\Services;

use App\Repositories\Eloquents\FileEloquent;

class FileService extends BaseCrudService
{
    /**
     * Create the file service.
     *
     * @param  FileEloquent  $fileRepository  File data repository.
     * @return void
     */
    public function __construct(FileEloquent $fileRepository)
    {
        parent::__construct($fileRepository);
    }
}
