<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PavCustom extends Model
{
    protected $table = 'pavs_custom';

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
        'store_id',
    ];

    /**
     * Get the parent PAV.
     *
     * @return BelongsTo<Pav, PavCustom> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }

    /**
     * Get the owning store.
     *
     * @return BelongsTo<Store, PavCustom> Store relation.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
