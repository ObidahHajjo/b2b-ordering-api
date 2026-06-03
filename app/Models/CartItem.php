<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'cart_id',
        'produit_ref',
        'quantity',
    ];

    /**
     * Get the parent cart.
     *
     * @return BelongsTo<Cart, CartItem> Cart relation.
     */
    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class);
    }

    /**
     * Get the linked product.
     *
     * @return BelongsTo<Produit, CartItem> Product relation.
     */
    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'produit_ref', 'ref');
    }
}
