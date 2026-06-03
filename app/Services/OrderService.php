<?php

namespace App\Services;

use App\Models\Commande;
use App\Models\Effectue;
use App\Models\Ligne;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    /**
     * Create the order service.
     *
     * @param  CartService  $cartService  Cart service.
     * @return void
     */
    public function __construct(private readonly CartService $cartService) {}

    /**
     * Get orders for the authenticated user.
     *
     * @param  User  $user  Authenticated user.
     * @return Collection<int, Commande> User orders.
     */
    public function userOrders(User $user): Collection
    {
        return Commande::query()
            ->whereHas('effectues', fn ($query) => $query->where('user_id', $user->id))
            ->with(['lignes.produit'])
            ->orderByDesc('date_creation')
            ->get();
    }

    /**
     * Place an order from the current cart.
     *
     * @param  User  $user  Authenticated user.
     * @return Commande Created order.
     */
    public function checkout(User $user): Commande
    {
        $cart = $this->cartService->getCart($user);
        $cart->load('items.produit');
        abort_if($cart->items->isEmpty(), 422, 'Cart is empty.');

        $order = DB::transaction(function () use ($user, $cart): Commande {
            $nextNumber = ((int) Commande::query()->max('numero')) + 1;
            $order = Commande::create([
                'numero' => max(1, $nextNumber),
                'date_creation' => now(),
                'statut' => 'en_attente',
            ]);

            foreach ($cart->items as $item) {
                Ligne::create([
                    'prix_unitaire' => $item->produit->prix,
                    'qte' => $item->quantity,
                    'produit_ref' => $item->produit_ref,
                    'commande_numero' => $order->numero,
                ]);
            }

            Effectue::create([
                'commande_numero' => $order->numero,
                'user_id' => $user->id,
            ]);

            $cart->items()->delete();

            return $order;
        });

        return $order->load(['lignes.produit']);
    }
}
