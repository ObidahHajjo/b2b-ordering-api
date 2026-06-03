<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'city',
        'street',
        'number',
        'postal_code',
    ];

    /**
     * Get stores using this address.
     *
     * @return HasMany<Store> Store relations.
     */
    public function stores(): HasMany
    {
        return $this->hasMany(Store::class);
    }
}
