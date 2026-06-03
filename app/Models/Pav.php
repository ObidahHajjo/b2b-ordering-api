<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pav extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nb_etage',
    ];

    /**
     * Get the standard PAV data.
     *
     * @return HasOne<PavStandard> Standard PAV relation.
     */
    public function standard(): HasOne
    {
        return $this->hasOne(PavStandard::class, 'pavs_id');
    }

    /**
     * Get the custom PAV data.
     *
     * @return HasOne<PavCustom> Custom PAV relation.
     */
    public function custom(): HasOne
    {
        return $this->hasOne(PavCustom::class, 'pavs_id');
    }

    /**
     * Get PAV floor quantities.
     *
     * @return HasMany<Contient> Floor quantity relations.
     */
    public function contenus(): HasMany
    {
        return $this->hasMany(Contient::class, 'pavs_id');
    }

    /**
     * Get order links for this PAV.
     *
     * @return HasMany<Inclut> Order PAV relations.
     */
    public function inclusions(): HasMany
    {
        return $this->hasMany(Inclut::class, 'pavs_id');
    }

    /**
     * Get line links for this PAV.
     *
     * @return HasMany<Compose> Line composition relations.
     */
    public function compositions(): HasMany
    {
        return $this->hasMany(Compose::class, 'pavs_id');
    }

    /**
     * Get discount links for this PAV.
     *
     * @return HasMany<Applique> Discount application relations.
     */
    public function applications(): HasMany
    {
        return $this->hasMany(Applique::class, 'pavs_id');
    }
}
