<?php

namespace Tests\Unit;

use App\Exceptions\MissingAttributesException;
use App\Models\Store;
use App\Services\StoreService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StoreServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a sample store payload.
     *
     * @param  array<string, mixed>  $overrides  Attribute overrides.
     * @return array<string, mixed> Store payload.
     */
    private function storePayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'TyDelice Paris',
            'legal_status' => 'SAS',
            'siret' => '12345678900011',
            'email' => 'paris@example.com',
            'phone' => '0102030405',
        ], $overrides);
    }

    /**
     * Test getById returns the store when it exists.
     */
    public function test_get_by_id_returns_store(): void
    {
        $store = Store::create($this->storePayload());
        $service = app(StoreService::class);

        $found = $service->getById($store->id);

        $this->assertNotNull($found);
        $this->assertSame($store->id, $found->id);
        $this->assertSame('TyDelice Paris', $found->name);
    }

    /**
     * Test getById returns null for an empty id.
     */
    public function test_get_by_id_returns_null_for_empty_id(): void
    {
        $service = app(StoreService::class);

        $this->assertNull($service->getById(0));
    }

    /**
     * Test getById returns null when the store does not exist.
     */
    public function test_get_by_id_returns_null_when_missing(): void
    {
        $service = app(StoreService::class);

        $this->assertNull($service->getById(9999));
    }

    /**
     * Test all returns every store.
     */
    public function test_all_returns_every_store(): void
    {
        Store::create($this->storePayload(['name' => 'A', 'siret' => '1', 'email' => 'a@example.com', 'phone' => '0100000001']));
        Store::create($this->storePayload(['name' => 'B', 'siret' => '2', 'email' => 'b@example.com', 'phone' => '0100000002']));
        $service = app(StoreService::class);

        $stores = $service->all();

        $this->assertCount(2, $stores);
    }

    /**
     * Test create persists a store.
     */
    public function test_create_persists_store(): void
    {
        $service = app(StoreService::class);

        $store = $service->create($this->storePayload(['name' => 'TyDelice Lyon', 'siret' => '98765432100033', 'email' => 'lyon@example.com', 'phone' => '0102030406']));

        $this->assertSame('TyDelice Lyon', $store->name);
        $this->assertDatabaseHas('stores', ['name' => 'TyDelice Lyon']);
    }

    /**
     * Test create throws when required attributes are missing.
     */
    public function test_create_throws_when_attributes_are_missing(): void
    {
        $service = app(StoreService::class);

        $this->expectException(MissingAttributesException::class);
        $service->create([]);
    }

    /**
     * Test update modifies the store.
     */
    public function test_update_modifies_store(): void
    {
        $store = Store::create($this->storePayload());
        $service = app(StoreService::class);

        $result = $service->update($store->id, ['name' => 'TyDelice Marseille']);

        $this->assertTrue($result);
        $this->assertSame('TyDelice Marseille', $store->fresh()->name);
    }

    /**
     * Test update returns false for an empty id.
     */
    public function test_update_returns_false_for_empty_id(): void
    {
        $service = app(StoreService::class);

        $this->assertFalse($service->update(0, ['name' => 'x']));
    }

    /**
     * Test update returns false when the store is missing.
     */
    public function test_update_returns_false_when_missing(): void
    {
        $service = app(StoreService::class);

        $this->assertFalse($service->update(9999, ['name' => 'x']));
    }

    /**
     * Test delete removes the store.
     */
    public function test_delete_removes_store(): void
    {
        $store = Store::create($this->storePayload());
        $service = app(StoreService::class);

        $result = $service->delete($store->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('stores', ['id' => $store->id]);
    }

    /**
     * Test delete returns false for an empty id.
     */
    public function test_delete_returns_false_for_empty_id(): void
    {
        $service = app(StoreService::class);

        $this->assertFalse($service->delete(0));
    }

    /**
     * Test delete returns false when the store is missing.
     */
    public function test_delete_returns_false_when_missing(): void
    {
        $service = app(StoreService::class);

        $this->assertFalse($service->delete(9999));
    }
}
