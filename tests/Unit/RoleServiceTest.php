<?php

namespace Tests\Unit;

use App\Exceptions\MissingAttributesException;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getById returns the role when it exists.
     */
    public function test_get_by_id_returns_role(): void
    {
        $role = Role::create(['name' => 'admin']);
        $service = app(RoleService::class);

        $found = $service->getById($role->id);

        $this->assertNotNull($found);
        $this->assertSame($role->id, $found->id);
        $this->assertSame('admin', $found->name);
    }

    /**
     * Test getById returns null for an empty id.
     */
    public function test_get_by_id_returns_null_for_empty_id(): void
    {
        $service = app(RoleService::class);

        $this->assertNull($service->getById(0));
    }

    /**
     * Test getById returns null when the role does not exist.
     */
    public function test_get_by_id_returns_null_when_missing(): void
    {
        $service = app(RoleService::class);

        $this->assertNull($service->getById(9999));
    }

    /**
     * Test getByName returns the role when it exists.
     */
    public function test_get_by_name_returns_role(): void
    {
        Role::create(['name' => 'manager']);
        $service = app(RoleService::class);

        $found = $service->getByName('manager');

        $this->assertNotNull($found);
        $this->assertSame('manager', $found->name);
    }

    /**
     * Test getByName returns null for an empty name.
     */
    public function test_get_by_name_returns_null_for_empty_name(): void
    {
        $service = app(RoleService::class);

        $this->assertNull($service->getByName(''));
        $this->assertNull($service->getByName('   '));
    }

    /**
     * Test getByName returns null when the role does not exist.
     */
    public function test_get_by_name_returns_null_when_missing(): void
    {
        $service = app(RoleService::class);

        $this->assertNull($service->getByName('unknown'));
    }

    /**
     * Test all returns every role.
     */
    public function test_all_returns_every_role(): void
    {
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        $service = app(RoleService::class);

        $roles = $service->all();

        $this->assertCount(2, $roles);
    }

    /**
     * Test create persists a role.
     */
    public function test_create_persists_role(): void
    {
        $service = app(RoleService::class);

        $role = $service->create(['name' => 'manager']);

        $this->assertSame('manager', $role->name);
        $this->assertDatabaseHas('roles', ['name' => 'manager']);
    }

    /**
     * Test create throws when required attributes are missing.
     */
    public function test_create_throws_when_attributes_are_missing(): void
    {
        $service = app(RoleService::class);

        $this->expectException(MissingAttributesException::class);
        $service->create([]);
    }

    /**
     * Test update modifies the role.
     */
    public function test_update_modifies_role(): void
    {
        $role = Role::create(['name' => 'user']);
        $service = app(RoleService::class);

        $result = $service->update($role->id, ['name' => 'member']);

        $this->assertTrue($result);
        $this->assertSame('member', $role->fresh()->name);
    }

    /**
     * Test update returns false for an empty id.
     */
    public function test_update_returns_false_for_empty_id(): void
    {
        $service = app(RoleService::class);

        $this->assertFalse($service->update(0, ['name' => 'x']));
    }

    /**
     * Test update returns false when the role is missing.
     */
    public function test_update_returns_false_when_missing(): void
    {
        $service = app(RoleService::class);

        $this->assertFalse($service->update(9999, ['name' => 'x']));
    }

    /**
     * Test delete removes the role.
     */
    public function test_delete_removes_role(): void
    {
        $role = Role::create(['name' => 'temp']);
        $service = app(RoleService::class);

        $result = $service->delete($role->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /**
     * Test delete returns false for an empty id.
     */
    public function test_delete_returns_false_for_empty_id(): void
    {
        $service = app(RoleService::class);

        $this->assertFalse($service->delete(0));
    }

    /**
     * Test delete returns false when the role is missing.
     */
    public function test_delete_returns_false_when_missing(): void
    {
        $service = app(RoleService::class);

        $this->assertFalse($service->delete(9999));
    }
}
