<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ligne extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'prix_unitaire',
        'qte',
        'produit_ref',
        'commande_numero',
        'reduction_id',
    ];

    /**
     * Get line casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'prix_unitaire' => 'decimal:2',
        ];
    }

    /**
     * Get the line product.
     *
     * @return BelongsTo<Produit, Ligne> Product relation.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_ref', 'ref');
    }

    /**
     * Get the line order.
     *
     * @return BelongsTo<Commande, Ligne> Order relation.
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_numero', 'numero');
    }

    /**
     * Get the line discount.
     *
     * @return BelongsTo<Reduction, Ligne> Discount relation.
     */
    public function reduction(): BelongsTo
    {
        return $this->belongsTo(Reduction::class);
    }

    /**
     * Get PAV composition links.
     *
     * @return HasMany<Compose> PAV composition relations.
     */
    public function compositions(): HasMany
    {
        return $this->hasMany(Compose::class);
    }

    /**
     * Get invoice links.
     *
     * @return HasMany<Concerne> Invoice line relations.
     */
    public function concerns(): HasMany
    {
        return $this->hasMany(Concerne::class);
    }

    /**
     * Get discount applications.
     *
     * @return HasMany<Applique> Discount application relations.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Applique::class);
    }
}
