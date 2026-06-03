<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inclut extends Model
{
    protected $table = 'inclut';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'commande_numero',
        'pavs_id',
    ];

    /**
     * Get the linked order.
     *
     * @return BelongsTo<Commande, Inclut> Order relation.
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_numero', 'numero');
    }

    /**
     * Get the linked PAV.
     *
     * @return BelongsTo<Pav, Inclut> PAV relation.
     */
    public function pav(): BelongsTo
    {
        return $this->belongsTo(Pav::class, 'pavs_id');
    }
}
