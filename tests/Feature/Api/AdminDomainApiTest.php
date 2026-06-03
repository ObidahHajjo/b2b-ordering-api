<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDomainApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can access every domain index endpoint.
     *
     * @return void
     */
    public function test_admin_can_access_every_domain_index_endpoint(): void
    {
        $admin = $this->createAdminUser();

        $endpoints = [
            '/api/admin/addresses' => 'addresses',
            '/api/admin/applications' => 'applications',
            '/api/admin/categories' => 'categories',
            '/api/admin/classifications' => 'classifications',
            '/api/admin/compositions' => 'compositions',
            '/api/admin/concerns' => 'concerns',
            '/api/admin/contents' => 'contents',
            '/api/admin/executions' => 'executions',
            '/api/admin/factures' => 'factures',
            '/api/admin/files' => 'files',
            '/api/admin/floors' => 'floors',
            '/api/admin/inclusions' => 'inclusions',
            '/api/admin/lines' => 'lines',
            '/api/admin/locations' => 'locations',
            '/api/admin/orders' => 'orders',
            '/api/admin/pavs' => 'pavs',
            '/api/admin/pav-customs' => 'pav_customs',
            '/api/admin/pav-standards' => 'pav_standards',
            '/api/admin/products' => 'products',
            '/api/admin/reductions' => 'reductions',
            '/api/admin/reductions-globales' => 'reductions_globales',
            '/api/admin/reductions-personnelles' => 'reductions_personnelles',
        ];

        foreach ($endpoints as $uri => $key) {
            $this->actingAs($admin, 'sanctum')
                ->getJson($uri)
                ->assertOk()
                ->assertJsonStructure([$key]);
        }
    }

    /**
     * Test admin can manage categories.
     *
     * @return void
     */
    public function test_admin_can_manage_categories(): void
    {
        $admin = $this->createAdminUser();

        $create = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/categories', [
                'libelle' => 'Viennoiseries',
            ])
            ->assertCreated()
            ->assertJsonPath('category.libelle', 'Viennoiseries');

        $id = (string) $create->json('category.id');

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/admin/categories/'.$id)
            ->assertOk()
            ->assertJsonPath('category.libelle', 'Viennoiseries');

        $this->actingAs($admin, 'sanctum')
            ->patchJson('/api/admin/categories/'.$id, [
                'libelle' => 'Patisseries',
            ])
            ->assertOk()
            ->assertJsonPath('category.libelle', 'Patisseries');

        $this->actingAs($admin, 'sanctum')
            ->deleteJson('/api/admin/categories/'.$id)
            ->assertOk()
            ->assertJsonPath('message', 'Category deleted.');
    }

    /**
     * Test admin can manage products.
     *
     * @return void
     */
    public function test_admin_can_manage_products(): void
    {
        $admin = $this->createAdminUser();

        $create = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/products', [
                'ref' => 'P00001',
                'nom' => 'Millefeuille',
                'prix' => 7.50,
                'poids' => 0.35,
                'liste_ingredient' => 'lait, farine, beurre',
                'est_disponible' => true,
            ])
            ->assertCreated()
            ->assertJsonPath('product.ref', 'P00001');

        $id = (string) $create->json('product.ref');

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/admin/products/'.$id)
            ->assertOk()
            ->assertJsonPath('product.nom', 'Millefeuille');

        $this->actingAs($admin, 'sanctum')
            ->patchJson('/api/admin/products/'.$id, [
                'nom' => 'Eclair chocolat',
            ])
            ->assertOk()
            ->assertJsonPath('product.nom', 'Eclair chocolat');

        $this->actingAs($admin, 'sanctum')
            ->deleteJson('/api/admin/products/'.$id)
            ->assertOk()
            ->assertJsonPath('message', 'Product deleted.');
    }

    /**
     * Test category creation validates payload.
     *
     * @return void
     */
    public function test_category_creation_validates_payload(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/categories', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['libelle']);
    }

    /**
     * Test product creation validates payload.
     *
     * @return void
     */
    public function test_product_creation_validates_payload(): void
    {
        $admin = $this->createAdminUser();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/products', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['ref', 'nom', 'prix', 'poids']);
    }

    /**
     * Test admin domain endpoints require authentication.
     *
     * @return void
     */
    public function test_admin_domain_endpoints_require_authentication(): void
    {
        $this->getJson('/api/admin/categories')->assertUnauthorized();
    }

    /**
     * Test non-admin users cannot access admin domain endpoints.
     *
     * @return void
     */
    public function test_non_admin_users_cannot_access_admin_domain_endpoints(): void
    {
        $user = $this->createRegularUser();

        $this->actingAs($user, 'sanctum')
            ->getJson('/api/admin/categories')
            ->assertForbidden();
    }

    /**
     * Create an admin user for API tests.
     *
     * @return User Admin user.
     */
    private function createAdminUser(): User
    {
        $adminRole = Role::create(['name' => 'admin']);
        $store = Store::create([
            'name' => 'TyDelice Paris',
            'legal_status' => 'SAS',
            'siret' => '12345678900011',
            'email' => 'store@example.com',
            'phone' => '0102030405',
        ]);

        return User::factory()->withoutTwoFactor()->create([
            'role_id' => $adminRole->id,
            'store_id' => $store->id,
        ]);
    }

    /**
     * Create a regular user for API tests.
     *
     * @return User Regular user.
     */
    private function createRegularUser(): User
    {
        $userRole = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'TyDelice Lyon',
            'legal_status' => 'SAS',
            'siret' => '12345678900022',
            'email' => 'lyon@example.com',
            'phone' => '0102030406',
        ]);

        return User::factory()->withoutTwoFactor()->create([
            'role_id' => $userRole->id,
            'store_id' => $store->id,
        ]);
    }
}
