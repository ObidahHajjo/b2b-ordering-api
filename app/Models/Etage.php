<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Etage extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nom',
    ];

    /**
     * Get PAV quantity links.
     *
     * @return HasMany<Contient> PAV quantity relations.
     */
    public function contenus(): HasMany
    {
        return $this->hasMany(Contient::class);
    }

    /**
     * Get product location links.
     *
     * @return HasMany<Localise> Product location relations.
     */
    public function localisations(): HasMany
    {
        return $this->hasMany(Localise::class);
    }
}
