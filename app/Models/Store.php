<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Store extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'siret',
        'legal_status',
        'email',
        'phone',
        'validation_date',
    ];

    /**
     * Get store casts.
     *
     * @return array<string, string> Cast definitions.
     */
    protected function casts(): array
    {
        return [
            'validation_date' => 'datetime',
        ];
    }

    protected $guarded = ['id'];

    /**
     * Get the store users.
     *
     * @return HasMany<User> User relation.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the store files.
     *
     * @return HasMany<File> File relation.
     */
    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }

    /**
     * Get custom PAVs owned by this store.
     *
     * @return HasMany<PavCustom> Custom PAV relations.
     */
    public function pavsCustom(): HasMany
    {
        return $this->hasMany(PavCustom::class);
    }
}
