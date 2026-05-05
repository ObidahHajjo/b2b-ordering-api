<?php

namespace Tests\Feature\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserApprovalTest extends TestCase
{
    use RefreshDatabase;

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

        $response = $this->actingAs($admin)->post(route('users.approve', [
            'hashId' => $pendingUser->hashid,
        ]));

        $response->assertRedirect(route('users.index', absolute: false));
        $this->assertDatabaseHas('audit_logs', [
            'category' => 'account',
            'event' => 'account_approved',
            'user_id' => $admin->id,
            'subject_id' => $pendingUser->id,
        ]);
        $this->assertNotNull($pendingUser->refresh()->is_active);
    }
}
