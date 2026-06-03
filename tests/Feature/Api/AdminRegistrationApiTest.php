<?php

namespace Tests\Feature\Api;

use App\Models\File;
use App\Models\Role;
use App\Models\Store;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminRegistrationApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test admins can view pending registrations.
     *
     * @return void
     */
    public function test_admins_can_view_pending_registrations(): void
    {
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);
        $adminStore = Store::create([
            'name' => 'Admin Store',
            'legal_status' => 'SAS',
            'siret' => '12345678900041',
            'email' => 'admin-store@example.com',
            'phone' => '0102030412',
            'validation_date' => now(),
        ]);
        $pendingStore = Store::create([
            'name' => 'Pending Store',
            'legal_status' => 'SARL',
            'siret' => '12345678900051',
            'email' => 'pending-store@example.com',
            'phone' => '0102030413',
        ]);

        $admin = User::factory()->withoutTwoFactor()->create([
            'role_id' => $adminRole->id,
            'store_id' => $adminStore->id,
            'is_active' => now(),
        ]);

        $pendingUser = User::factory()->withoutTwoFactor()->create([
            'role_id' => $userRole->id,
            'store_id' => $pendingStore->id,
            'first_name' => 'Pending',
            'last_name' => 'Client',
            'email' => 'pending@example.com',
            'is_active' => null,
        ]);

        File::create([
            'name' => 'kbis.pdf',
            'path' => 'kbis/kbis.pdf',
            'uploaded_at' => now(),
            'store_id' => $pendingStore->id,
        ]);

        $this->actingAs($admin, 'sanctum')
            ->getJson('/api/admin/registrations/pending')
            ->assertOk()
            ->assertJsonPath('pending_registrations.0.email', $pendingUser->email)
            ->assertJsonPath('pending_registrations.0.store.files.0.name', 'kbis.pdf');
    }
}
