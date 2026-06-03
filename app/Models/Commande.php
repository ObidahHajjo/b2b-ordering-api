<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Commande extends Model
{
    protected $primaryKey = 'numero';

    public $incrementing = false;

    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'numero',
        'date_creation',
        'date_validation',
        'statut',
    ];

    /**
     * Get order casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'date_creation' => 'datetime',
            'date_validation' => 'datetime',
        ];
    }

    /**
     * Get order lines.
     *
     * @return HasMany<Ligne> Line relations.
     */
    public function lignes(): HasMany
    {
        return $this->hasMany(Ligne::class, 'commande_numero', 'numero');
    }

    /**
     * Get the order invoice.
     *
     * @return HasOne<Facture> Invoice relation.
     */
    public function facture(): HasOne
    {
        return $this->hasOne(Facture::class, 'commande_numero', 'numero');
    }

    /**
     * Get user links for this order.
     *
     * @return HasMany<Effectue> User order relations.
     */
    public function effectues(): HasMany
    {
        return $this->hasMany(Effectue::class, 'commande_numero', 'numero');
    }

    /**
     * Get PAV links for this order.
     *
     * @return HasMany<Inclut> PAV order relations.
     */
    public function inclusions(): HasMany
    {
        return $this->hasMany(Inclut::class, 'commande_numero', 'numero');
    }
}
