<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contient extends Model
{
    protected $table = 'contient';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pavs_id',
        'etage_id',
        'qte',
    ];

    /**
     * Get the linked PAV.
     *
     * @return BelongsTo<Pav, Contient> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }

    /**
     * Get the linked floor.
     *
     * @return BelongsTo<Etage, Contient> Floor relation.
     */
    public function etage(): BelongsTo
    {
        return $this->belongsTo(Etage::class);
    }
}
