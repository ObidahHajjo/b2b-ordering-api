<?php

namespace App\Repositories\Eloquents;

use App\Models\File;

class FileEloquent extends BaseEloquentRepository
{
    /**
     * Create the file repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(File::class);
    }
}
