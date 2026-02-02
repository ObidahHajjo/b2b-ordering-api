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
        'validation_date'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'validation_date' => 'datetime',
            'email' => 'email',
        ];
    }

    protected $guarded = ['id'];

    /**
     * Get the users associated with this role.
     *
     * @return HasMany<User>
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Get the files associated with this store.
     *
     * @return HasMany<File>
     */
    public function files() : HasMany
    {
        return $this->hasMany(File::class);
    }
}
