<?php

namespace Tests\Unit;

use App\Exceptions\MissingAttributesException;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Build a sample user payload.
     *
     * @param  array<string, mixed>  $overrides  Attribute overrides.
     * @return array<string, mixed> User payload.
     */
    private function userPayload(array $overrides = []): array
    {
        return array_merge([
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => Hash::make('password'),
            'phone' => '0102030405',
            'role_id' => 1,
            'store_id' => 1,
        ], $overrides);
    }

    /**
     * Build role and store fixtures for user tests.
     *
     * @return array{0: Role, 1: Store} Role and store.
     */
    private function fixtures(): array
    {
        $role = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'TyDelice Paris',
            'legal_status' => 'SAS',
            'siret' => '12345678900011',
            'email' => 'store@example.com',
            'phone' => '0102030405',
        ]);

        return [$role, $store];
    }

    /**
     * Test getById returns the user with eager-loaded relations.
     */
    public function test_get_by_id_returns_user(): void
    {
        [$role, $store] = $this->fixtures();
        $user = User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $found = $service->getById($user->id);

        $this->assertNotNull($found);
        $this->assertSame($user->id, $found->id);
        $this->assertTrue($found->relationLoaded('role'));
        $this->assertTrue($found->relationLoaded('store'));
    }

    /**
     * Test getById returns null for an empty id.
     */
    public function test_get_by_id_returns_null_for_empty_id(): void
    {
        $service = app(UserService::class);

        $this->assertNull($service->getById(0));
    }

    /**
     * Test getById returns null when the user does not exist.
     */
    public function test_get_by_id_returns_null_when_missing(): void
    {
        $service = app(UserService::class);

        $this->assertNull($service->getById(9999));
    }

    /**
     * Test getByEmail returns the user when it exists.
     */
    public function test_get_by_email_returns_user(): void
    {
        [$role, $store] = $this->fixtures();
        User::factory()->withoutTwoFactor()->create([
            'email' => 'ada@example.com',
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $found = $service->getByEmail('ada@example.com');

        $this->assertNotNull($found);
        $this->assertSame('ada@example.com', $found->email);
    }

    /**
     * Test getByEmail returns null for an empty email.
     */
    public function test_get_by_email_returns_null_for_empty_email(): void
    {
        $service = app(UserService::class);

        $this->assertNull($service->getByEmail(''));
        $this->assertNull($service->getByEmail('   '));
    }

    /**
     * Test getByEmail returns null when the user does not exist.
     */
    public function test_get_by_email_returns_null_when_missing(): void
    {
        $service = app(UserService::class);

        $this->assertNull($service->getByEmail('nobody@example.com'));
    }

    /**
     * Test all returns every user with eager-loaded relations.
     */
    public function test_all_returns_every_user(): void
    {
        [$role, $store] = $this->fixtures();
        User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $users = $service->all();

        $this->assertCount(2, $users);
        $this->assertTrue($users->first()->relationLoaded('role'));
        $this->assertTrue($users->first()->relationLoaded('store'));
    }

    /**
     * Test create persists a user.
     */
    public function test_create_persists_user(): void
    {
        [$role, $store] = $this->fixtures();
        $service = app(UserService::class);

        $user = $service->create($this->userPayload([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]));

        $this->assertSame('ada@example.com', $user->email);
        $this->assertDatabaseHas('users', ['email' => 'ada@example.com']);
    }

    /**
     * Test create throws when required attributes are missing.
     */
    public function test_create_throws_when_attributes_are_missing(): void
    {
        $service = app(UserService::class);

        $this->expectException(MissingAttributesException::class);
        $service->create(['email' => 'incomplete@example.com']);
    }

    /**
     * Test update modifies the user.
     */
    public function test_update_modifies_user(): void
    {
        [$role, $store] = $this->fixtures();
        $user = User::factory()->withoutTwoFactor()->create([
            'first_name' => 'Ada',
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $result = $service->update($user->id, ['first_name' => 'Grace']);

        $this->assertTrue($result);
        $this->assertSame('Grace', $user->fresh()->first_name);
    }

    /**
     * Test update returns false for an empty id.
     */
    public function test_update_returns_false_for_empty_id(): void
    {
        $service = app(UserService::class);

        $this->assertFalse($service->update(0, ['first_name' => 'x']));
    }

    /**
     * Test update returns false for empty attributes.
     */
    public function test_update_returns_false_for_empty_attributes(): void
    {
        [$role, $store] = $this->fixtures();
        $user = User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $this->assertFalse($service->update($user->id, []));
    }

    /**
     * Test update returns false when the user is missing.
     */
    public function test_update_returns_false_when_missing(): void
    {
        $service = app(UserService::class);

        $this->assertFalse($service->update(9999, ['first_name' => 'x']));
    }

    /**
     * Test delete removes the user.
     */
    public function test_delete_removes_user(): void
    {
        [$role, $store] = $this->fixtures();
        $user = User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);
        $service = app(UserService::class);

        $result = $service->delete($user->id);

        $this->assertTrue($result);
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /**
     * Test delete returns false for an empty id.
     */
    public function test_delete_returns_false_for_empty_id(): void
    {
        $service = app(UserService::class);

        $this->assertFalse($service->delete(0));
    }

    /**
     * Test delete returns false when the user is missing.
     */
    public function test_delete_returns_false_when_missing(): void
    {
        $service = app(UserService::class);

        $this->assertFalse($service->delete(9999));
    }
}
