<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reduction extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'taux',
    ];

    /**
     * Get the personnel reduction data.
     *
     * @return HasOne<ReductionPersonnel> Personnel reduction relation.
     */
    public function personnel(): HasOne
    {
        return $this->hasOne(ReductionPersonnel::class);
    }

    /**
     * Get the global reduction data.
     *
     * @return HasOne<ReductionGlobale> Global reduction relation.
     */
    public function globale(): HasOne
    {
        return $this->hasOne(ReductionGlobale::class);
    }

    /**
     * Get invoices using this discount.
     *
     * @return HasMany<Facture> Invoice relations.
     */
    public function factures(): HasMany
    {
        return $this->hasMany(Facture::class);
    }

    /**
     * Get lines using this discount.
     *
     * @return HasMany<Ligne> Line relations.
     */
    public function lignes(): HasMany
    {
        return $this->hasMany(Ligne::class);
    }

    /**
     * Get discount applications.
     *
     * @return HasMany<Applique> Application relations.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Applique::class);
    }
}
