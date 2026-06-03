<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Classifie extends Model
{
    protected $table = 'classifie';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'produit_ref',
        'categorie_id',
    ];

    /**
     * Get the linked product.
     *
     * @return BelongsTo<Produit, Classifie> Product relation.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_ref', 'ref');
    }

    /**
     * Get the linked category.
     *
     * @return BelongsTo<Categorie, Classifie> Category relation.
     */
    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }
}
