<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Concerne extends Model
{
    protected $table = 'concerne';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'facture_id',
        'ligne_id',
    ];

    /**
     * Get the linked invoice.
     *
     * @return BelongsTo<Facture, Concerne> Invoice relation.
     */
    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }

    /**
     * Get the linked line.
     *
     * @return BelongsTo<Ligne, Concerne> Line relation.
     */
    public function ligne(): BelongsTo
    {
        return $this->belongsTo(Ligne::class);
    }
}
