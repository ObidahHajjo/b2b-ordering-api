<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Facture extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'date_facturation',
        'statut',
        'fdp',
        'commande_numero',
        'reduction_id',
    ];

    /**
     * Get invoice casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'date_facturation' => 'datetime',
            'fdp' => 'decimal:2',
        ];
    }

    /**
     * Get the invoice order.
     *
     * @return BelongsTo<Commande, Facture> Order relation.
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_numero', 'numero');
    }

    /**
     * Get the invoice discount.
     *
     * @return BelongsTo<Reduction, Facture> Discount relation.
     */
    public function reduction(): BelongsTo
    {
        return $this->belongsTo(Reduction::class);
    }

    /**
     * Get line links for this invoice.
     *
     * @return HasMany<Concerne> Invoice line relations.
     */
    public function concerns(): HasMany
    {
        return $this->hasMany(Concerne::class);
    }
}
