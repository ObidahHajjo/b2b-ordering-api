<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Compose extends Model
{
    protected $table = 'compose';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'pavs_id',
        'ligne_id',
    ];

    /**
     * Get the linked PAV.
     *
     * @return BelongsTo<Pav, Compose> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }

    /**
     * Get the linked line.
     *
     * @return BelongsTo<Ligne, Compose> Line relation.
     */
    public function ligne(): BelongsTo
    {
        return $this->belongsTo(Ligne::class);
    }
}
