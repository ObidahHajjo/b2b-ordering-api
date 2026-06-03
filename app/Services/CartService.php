<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\User;

class CartService
{
    /**
     * Create the cart service.
     *
     * @param  ShippingCalculatorService  $shippingCalculator  Shipping calculator.
     * @return void
     */
    public function __construct(private readonly ShippingCalculatorService $shippingCalculator) {}

    /**
     * Get or create the user cart with products.
     *
     * @param  User  $user  Authenticated user.
     * @return Cart User cart.
     */
    public function getCart(User $user): Cart
    {
        return Cart::query()
            ->firstOrCreate(['user_id' => $user->id])
            ->load('items.produit');
    }

    /**
     * Add or update a product in the cart.
     *
     * @param  User  $user  Authenticated user.
     * @param  string  $produitRef  Product reference.
     * @param  int  $quantity  Requested quantity.
     * @return Cart Updated cart.
     */
    public function addItem(User $user, string $produitRef, int $quantity): Cart
    {
        $cart = $this->getCart($user);

        CartItem::query()->updateOrCreate(
            ['cart_id' => $cart->id, 'produit_ref' => $produitRef],
            ['quantity' => $quantity]
        );

        return $this->getCart($user);
    }

    /**
     * Update one cart item quantity.
     *
     * @param  User  $user  Authenticated user.
     * @param  int  $itemId  Cart item id.
     * @param  int  $quantity  New quantity.
     * @return Cart Updated cart.
     */
    public function updateItem(User $user, int $itemId, int $quantity): Cart
    {
        $cart = $this->getCart($user);

        $cart->items()->whereKey($itemId)->update([
            'quantity' => $quantity,
        ]);

        return $this->getCart($user);
    }

    /**
     * Remove one cart item.
     *
     * @param  User  $user  Authenticated user.
     * @param  int  $itemId  Cart item id.
     * @return Cart Updated cart.
     */
    public function removeItem(User $user, int $itemId): Cart
    {
        $cart = $this->getCart($user);
        $cart->items()->whereKey($itemId)->delete();

        return $this->getCart($user);
    }

    /**
     * Clear the user cart.
     *
     * @param  User  $user  Authenticated user.
     * @return void
     */
    public function clear(User $user): void
    {
        $this->getCart($user)->items()->delete();
    }

    /**
     * Build the cart summary payload.
     *
     * @param  Cart  $cart  Loaded cart.
     * @return array<string, mixed> Cart summary.
     */
    public function summary(Cart $cart): array
    {
        $items = $cart->items->map(function (CartItem $item): array {
            $unitPrice = (float) $item->produit->prix;
            $weight = (float) $item->produit->poids;

            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'product' => [
                    'ref' => $item->produit->ref,
                    'nom' => $item->produit->nom,
                    'prix' => $unitPrice,
                    'poids' => $weight,
                ],
                'line_total' => round($unitPrice * $item->quantity, 2),
                'line_weight' => round($weight * $item->quantity, 2),
            ];
        })->values();

        $subtotal = (float) $items->sum('line_total');
        $weight = (float) $items->sum('line_weight');
        $shipping = $this->shippingCalculator->calculate($weight);

        return [
            'items' => $items,
            'subtotal' => round($subtotal, 2),
            'shipping_total' => round($shipping, 2),
            'grand_total' => round($subtotal + $shipping, 2),
            'total_weight' => round($weight, 2),
        ];
    }
}
