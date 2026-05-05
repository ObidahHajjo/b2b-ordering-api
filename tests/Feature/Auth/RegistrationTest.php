<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get(route('register'));

        $response->assertStatus(200);
    }

    public function test_new_users_can_register_but_must_wait_for_admin_approval()
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::where('email', 'test@example.com')->first();

        $this->assertGuest();
        $this->assertNotNull($user);
        $this->assertNull($user->is_active);
        $this->assertDatabaseHas('audit_logs', [
            'category' => 'account',
            'event' => 'account_registered',
            'subject_id' => $user->id,
        ]);
        $response->assertRedirect(route('login', absolute: false));
    }
}
