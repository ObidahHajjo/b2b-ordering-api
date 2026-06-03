<?php

namespace Tests\Feature\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApprovalTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admin can approve a pending user.
     *
     * @return void
     */
    public function test_admin_can_approve_a_pending_user(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        $admin = User::factory()->create([
            'role_id' => $adminRole->id,
            'is_active' => now(),
        ]);

        $pendingUser = User::factory()->pendingApproval()->create([
            'role_id' => $userRole->id,
        ]);

        $response = $this->actingAs($admin, 'sanctum')->postJson(route('api.users.approve', [
            'hashId' => $pendingUser->hashid,
        ]));

        $response
            ->assertOk()
            ->assertJsonPath('message', 'User approved.')
            ->assertJsonPath('user.id', $pendingUser->hashid);

        $this->assertNotNull($pendingUser->refresh()->is_active);
    }
}
