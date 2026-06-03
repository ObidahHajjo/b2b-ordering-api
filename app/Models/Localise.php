<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Localise extends Model
{
    protected $table = 'localise';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'etage_id',
        'produit_ref',
    ];

    /**
     * Get the linked floor.
     *
     * @return BelongsTo<Etage, Localise> Floor relation.
     */
    public function etage(): BelongsTo
    {
        return $this->belongsTo(Etage::class);
    }

    /**
     * Get the linked product.
     *
     * @return BelongsTo<Produit, Localise> Product relation.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_ref', 'ref');
    }
}
