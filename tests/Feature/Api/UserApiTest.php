<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin user management.
     */
    public function test_admin_can_manage_users(): void
    {
        [$admin, $role, $store] = $this->createAdminContext();
        $target = User::factory()->withoutTwoFactor()->pendingApproval()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/users')
            ->assertOk()
            ->assertJsonStructure(['users']);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/users/'.$target->hashid)
            ->assertOk()
            ->assertJsonPath('user.email', $target->email);

        $this->actingAs($admin, 'sanctum')
            ->patchJson('/api/users/'.$target->hashid, [
                'first_name' => 'Updated',
            ])
            ->assertOk()
            ->assertJsonPath('user.first_name', 'Updated');

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users/'.$target->hashid.'/approve')
            ->assertOk()
            ->assertJsonPath('user.is_active', fn ($value) => $value !== null);

        $this->assertNotNull($store->fresh()->validation_date);

        $this->actingAs($admin, 'sanctum')
            ->deleteJson('/api/users/'.$target->hashid)
            ->assertOk();
    }

    /**
     * Test admin user creation.
     */
    public function test_admin_can_create_user(): void
    {
        [$admin, $role, $store] = $this->createAdminContext();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', [
                'first_name' => 'Grace',
                'last_name' => 'Hopper',
                'email' => 'grace@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'phone' => '0102030405',
                'role_id' => $role->id,
                'store_id' => $store->id,
            ])
            ->assertCreated()
            ->assertJsonPath('user.email', 'grace@example.com');
    }

    /**
     * Test user creation validation.
     */
    public function test_create_user_validates_payload(): void
    {
        [$admin] = $this->createAdminContext();

        $this->actingAs($admin, 'sanctum')
            ->postJson('/api/users', [])
            ->assertUnprocessable();
    }

    /**
     * Test non-admin creation denial.
     */
    public function test_non_admin_cannot_create_user(): void
    {
        [$user, $role, $store] = $this->createUserContext();

        $this->actingAs($user, 'sanctum')
            ->postJson('/api/users', [
                'first_name' => 'No',
                'last_name' => 'Access',
                'email' => 'no-access@example.com',
                'password' => 'password',
                'password_confirmation' => 'password',
                'phone' => '0102030405',
                'role_id' => $role->id,
                'store_id' => $store->id,
            ])
            ->assertForbidden();
    }

    /**
     * Test support endpoints.
     */
    public function test_roles_and_stores_support_endpoints_are_available(): void
    {
        [$admin] = $this->createAdminContext();

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/roles')
            ->assertOk()
            ->assertJsonStructure(['roles']);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/stores')
            ->assertOk()
            ->assertJsonStructure(['stores']);
    }

    /**
     * Create an admin test context.
     *
     * @return array{0: User, 1: Role, 2: Store} Admin, user role, and store.
     */
    private function createAdminContext(): array
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'TyDelice Paris',
            'legal_status' => 'SAS',
            'siret' => '12345678900011',
            'email' => 'store@example.com',
            'phone' => '0102030405',
        ]);
        $admin = User::factory()->withoutTwoFactor()->create([
            'role_id' => $adminRole->id,
            'store_id' => $store->id,
        ]);

        return [$admin, $userRole, $store];
    }

    /**
     * Create a user test context.
     *
     * @return array{0: User, 1: Role, 2: Store} User, role, and store.
     */
    private function createUserContext(): array
    {
        $role = Role::create(['name' => 'user']);
        $store = Store::create([
            'name' => 'TyDelice Lyon',
            'legal_status' => 'SAS',
            'siret' => '12345678900022',
            'email' => 'lyon@example.com',
            'phone' => '0102030406',
        ]);
        $user = User::factory()->withoutTwoFactor()->create([
            'role_id' => $role->id,
            'store_id' => $store->id,
        ]);

        return [$user, $role, $store];
    }
}
