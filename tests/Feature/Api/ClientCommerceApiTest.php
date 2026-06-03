<?php

namespace Tests\Feature\Api;

use App\Models\Categorie;
use App\Models\Classifie;
use App\Models\Produit;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientCommerceApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test approved clients can browse the catalog.
     *
     * @return void
     */
    public function test_approved_clients_can_browse_the_catalog(): void
    {
        $user = $this->createApprovedUser();
        $category = Categorie::create(['libelle' => 'Viennoiseries']);
        $product = Produit::create([
            'ref' => 'P10001',
            'nom' => 'Croissant',
            'prix' => 1.50,
            'poids' => 0.08,
            'liste_ingredient' => 'farine, beurre',
            'est_disponible' => true,
        ]);
        Classifie::create([
            'produit_ref' => $product->ref,
            'categorie_id' => $category->id,
        ]);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/client/catalog/products')
            ->assertOk()
            ->assertJsonPath('products.0.ref', 'P10001')
            ->assertJsonPath('products.0.categories.0.libelle', 'Viennoiseries');
    }

    /**
     * Test approved clients can manage cart and place orders.
     *
     * @return void
     */
    public function test_approved_clients_can_manage_cart_and_place_orders(): void
    {
        $user = $this->createApprovedUser();
        $product = Produit::create([
            'ref' => 'P10002',
            'nom' => 'Pain au chocolat',
            'prix' => 2.50,
            'poids' => 0.20,
            'liste_ingredient' => 'farine, chocolat',
            'est_disponible' => true,
        ]);

        $add = $this->actingAs($user, 'sanctum')
            ->postJson('/api/client/cart/items', [
                'produit_ref' => $product->ref,
                'quantity' => 3,
            ])
            ->assertCreated()
            ->assertJsonPath('cart.items.0.product.ref', 'P10002')
            ->assertJsonPath('cart.grand_total', 22.5);

        $itemId = $add->json('cart.items.0.id');

        $this->actingAs($user, 'sanctum')
            ->patchJson('/api/client/cart/items/'.$itemId, [
                'quantity' => 2,
            ])
            ->assertOk()
            ->assertJsonPath('cart.items.0.quantity', 2);

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/client/cart')
            ->assertOk()
            ->assertJsonPath('cart.subtotal', fn ($value) => (float) $value === 5.0);

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/client/orders')
            ->assertCreated()
            ->assertJsonPath('message', 'Order placed.')
            ->assertJsonPath('order.items.0.product.ref', 'P10002');

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/client/orders')
            ->assertOk()
            ->assertJsonCount(1, 'orders');
    }

    /**
     * Test pending users cannot access the commerce area.
     *
     * @return void
     */
    public function test_pending_users_cannot_access_the_commerce_area(): void
    {
        $user = $this->createPendingUser();

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/client/catalog/products')
            ->assertForbidden();
    }

    /**
     * Create an approved user.
     *
     * @return User Approved user.
     */
    private function createApprovedUser(): User
    {
        $role = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'Magasin Nantes',
            'legal_status' => 'SARL',
            'siret' => '12345678900021',
            'email' => 'nantes@example.com',
            'phone' => '0102030410',
            'validation_date' => now(),
        ]);

        return User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
            'is_active' => now(),
        ]);
    }

    /**
     * Create a pending user.
     *
     * @return User Pending user.
     */
    private function createPendingUser(): User
    {
        $role = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'Magasin Rennes',
            'legal_status' => 'SARL',
            'siret' => '12345678900031',
            'email' => 'rennes@example.com',
            'phone' => '0102030411',
        ]);

        return User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
            'is_active' => null,
        ]);
    }
}
