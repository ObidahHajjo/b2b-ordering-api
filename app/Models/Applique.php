<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Applique extends Model
{
    protected $table = 'applique';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'reduction_id',
        'ligne_id',
        'pavs_id',
    ];

    /**
     * Get the linked discount.
     *
     * @return BelongsTo<Reduction, Applique> Discount relation.
     */
    public function reduction(): BelongsTo
    {
        return $this->belongsTo(Reduction::class);
    }

    /**
     * Get the linked line.
     *
     * @return BelongsTo<Ligne, Applique> Line relation.
     */
    public function ligne(): BelongsTo
    {
        return $this->belongsTo(Ligne::class);
    }

    /**
     * Get the linked PAV.
     *
     * @return BelongsTo<Pav, Applique> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }
}
