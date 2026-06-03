<?php

namespace App\Repositories\Eloquents;

use App\Models\AuditLog;

class AuditLogEloquent extends BaseEloquentRepository
{
    /**
     * Create the audit log repository.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct(AuditLog::class);
    }
}
