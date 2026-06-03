<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Categorie extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'libelle',
    ];

    /**
     * Get product classification links.
     *
     * @return HasMany<Classifie> Product classification relations.
     */
    public function classifications(): HasMany
    {
        return $this->hasMany(Classifie::class);
    }
}
