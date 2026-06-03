<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Role extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
    ];

    protected $guarded = [
        'id',
    ];

    /**
     * Get the role users.
     *
     * @return HasMany<User> User relation.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }
}
