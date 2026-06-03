<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PavStandard extends Model
{
    protected $table = 'pavs_standard';

    protected $primaryKey = 'pavs_id';

    public $incrementing = false;

    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pavs_id',
        'nom',
    ];

    /**
     * Get the parent PAV.
     *
     * @return BelongsTo<Pav, PavStandard> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }
}
