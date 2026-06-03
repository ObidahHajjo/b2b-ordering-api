<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Effectue extends Model
{
    protected $table = 'effectue';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'commande_numero',
        'user_id',
    ];

    /**
     * Get the linked order.
     *
     * @return BelongsTo<Commande, Effectue> Order relation.
     */
    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'commande_numero', 'numero');
    }

    /**
     * Get the linked user.
     *
     * @return BelongsTo<User, Effectue> User relation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
