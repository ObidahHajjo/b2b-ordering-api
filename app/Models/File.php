<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class File extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'path',
        'uploaded_at',
    ];

    protected $guarded = ['id'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the store associated with this file.
     *
     * @return BelongsTo<Store>
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
