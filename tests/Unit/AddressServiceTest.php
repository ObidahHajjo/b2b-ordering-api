<?php

namespace Tests\Unit;

use App\Models\Address;
use App\Services\AddressService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a sample address payload.
     *
     * @param  array<string, mixed>  $overrides  Attribute overrides.
     * @return array<string, mixed> Address payload.
     */
    private function addressPayload(array $overrides = []): array
    {
        return array_merge([
            'city' => 'Paris',
            'street' => 'Rue de Rivoli',
            'number' => '12',
            'postal_code' => '75001',
        ], $overrides);
    }

    /**
     * Test getById returns the address when it exists.
     *
     * @return void
     */
    public function test_get_by_id_returns_address(): void
    {
        $address = Address::create($this->addressPayload());
        $service = app(AddressService::class);

        $found = $service->getById($address->id);

        $this->assertNotNull($found);
        $this->assertSame($address->id, $found->id);
    }

    /**
     * Test getById returns null for an empty id.
     *
     * @return void
     */
    public function test_get_by_id_returns_null_for_empty_id(): void
    {
        $service = app(AddressService::class);

        $this->assertNull($service->getById(0));
    }

    /**
     * Test all returns every address.
     *
     * @return void
     */
    public function test_all_returns_every_address(): void
    {
        Address::create($this->addressPayload());
        Address::create($this->addressPayload(['number' => '14']));
        $service = app(AddressService::class);

        $addresses = $service->all();

        $this->assertCount(2, $addresses);
    }

    /**
     * Test create persists an address.
     *
     * @return void
     */
    public function test_create_persists_address(): void
    {
        $service = app(AddressService::class);

        $address = $service->create($this->addressPayload(['city' => 'Lyon', 'number' => '20']));

        $this->assertSame('Lyon', $address->city);
        $this->assertDatabaseHas('addresses', ['city' => 'Lyon']);
    }

    /**
     * Test update modifies the address.
     *
     * @return void
     */
    public function test_update_modifies_address(): void
    {
        $address = Address::create($this->addressPayload());
        $service = app(AddressService::class);

        $result = $service->update($address->id, ['city' => 'Marseille']);

        $this->assertTrue($result);
        $this->assertSame('Marseille', $address->fresh()->city);
    }

    /**
     * Test update returns false for empty attributes.
     *
     * @return void
     */
    public function test_update_returns_false_for_empty_attributes(): void
    {
        $address = Address::create($this->addressPayload());
        $service = app(AddressService::class);

        $this->assertFalse($service->update($address->id, []));
    }

    /**
     * Test delete removes the address.
     *
     * @return void
     */
    public function test_delete_removes_address(): void
    {
        $address = Address::create($this->addressPayload());
        $service = app(AddressService::class);

        $result = $service->delete($address->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('addresses', ['id' => $address->id]);
    }
}
