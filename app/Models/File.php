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
        'store_id',
    ];

    protected $guarded = ['id'];

    /**
     * Get file casts.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the file store.
     *
     * @return BelongsTo<Store, File> Store relation.
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
