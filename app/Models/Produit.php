<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produit extends Model
{
    protected $primaryKey = 'ref';

    public $incrementing = false;

    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ref',
        'nom',
        'prix',
        'poids',
        'liste_ingredient',
        'est_disponible',
    ];

    /**
     * Get product casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'prix' => 'decimal:2',
            'poids' => 'decimal:2',
            'est_disponible' => 'boolean',
        ];
    }

    /**
     * Get product line items.
     *
     * @return HasMany<Ligne> Line item relations.
     */
    public function lignes(): HasMany
    {
        return $this->hasMany(Ligne::class, 'produit_ref', 'ref');
    }

    /**
     * Get category links.
     *
     * @return HasMany<Classifie> Category link relations.
     */
    public function classifications(): HasMany
    {
        return $this->hasMany(Classifie::class, 'produit_ref', 'ref');
    }

    /**
     * Get floor location links.
     *
     * @return HasMany<Localise> Floor location relations.
     */
    public function localisations(): HasMany
    {
        return $this->hasMany(Localise::class, 'produit_ref', 'ref');
    }
}
