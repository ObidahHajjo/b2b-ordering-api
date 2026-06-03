<?php

namespace Tests\Unit;

use App\Models\Produit;
use App\Services\ProduitService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProduitServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a sample product payload.
     *
     * @param  array<string, mixed>  $overrides  Attribute overrides.
     * @return array<string, mixed> Product payload.
     */
    private function produitPayload(array $overrides = []): array
    {
        return array_merge([
            'ref' => 'PDT-001',
            'nom' => 'Tarte aux pommes',
            'prix' => 12.50,
            'poids' => 0.55,
            'liste_ingredient' => 'pommes, farine, beurre',
            'est_disponible' => true,
        ], $overrides);
    }

    /**
     * Test getById returns the product when it exists.
     *
     * @return void
     */
    public function test_get_by_id_returns_product(): void
    {
        $product = Produit::create($this->produitPayload());
        $service = app(ProduitService::class);

        $found = $service->getById($product->ref);

        $this->assertNotNull($found);
        $this->assertSame($product->ref, $found->getKey());
    }

    /**
     * Test getById returns null for an empty id.
     *
     * @return void
     */
    public function test_get_by_id_returns_null_for_empty_string_id(): void
    {
        $service = app(ProduitService::class);

        $this->assertNull($service->getById(''));
    }

    /**
     * Test update modifies the product.
     *
     * @return void
     */
    public function test_update_modifies_product(): void
    {
        $product = Produit::create($this->produitPayload());
        $service = app(ProduitService::class);

        $result = $service->update($product->ref, ['nom' => 'Tarte citron']);

        $this->assertTrue($result);
        $this->assertSame('Tarte citron', $product->fresh()->nom);
    }

    /**
     * Test delete removes the product.
     *
     * @return void
     */
    public function test_delete_removes_product(): void
    {
        $product = Produit::create($this->produitPayload());
        $service = app(ProduitService::class);

        $result = $service->delete($product->ref);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('produits', ['ref' => $product->ref]);
    }
}
