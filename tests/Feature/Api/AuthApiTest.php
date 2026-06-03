<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test registration returns a token.
     */
    public function test_user_can_register_and_receive_token(): void
    {
        $response = $this->postJson('/api/auth/register', [
            'first_name' => 'Ada',
            'last_name' => 'Lovelace',
            'email' => 'ada@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response
            ->assertCreated()
            ->assertJsonStructure([
                'token',
                'token_type',
                'user' => ['id', 'first_name', 'last_name', 'email'],
            ])
            ->assertJsonPath('token_type', 'Bearer');

        $this->assertDatabaseHas('users', [
            'email' => 'ada@example.com',
        ]);
    }

    /**
     * Test registration validates payload.
     *
     * @return void
     */
    public function test_register_validates_required_fields(): void
    {
        $this->postJson('/api/auth/register', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Test login returns current user access.
     */
    public function test_approved_user_can_login_and_fetch_current_user(): void
    {
        $user = User::factory()->withoutTwoFactor()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password'),
        ]);

        $login = $this->postJson('/api/auth/login', [
            'email' => 'api@example.com',
            'password' => 'password',
        ]);

        $token = $login
            ->assertOk()
            ->assertJsonPath('token_type', 'Bearer')
            ->json('token');

        $this->withToken($token)
            ->getJson('/api/auth/me')
            ->assertOk()
            ->assertJsonPath('user.email', $user->email);
    }

    /**
     * Test invalid login is rejected.
     */
    public function test_login_rejects_invalid_credentials(): void
    {
        User::factory()->withoutTwoFactor()->create([
            'email' => 'api@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'api@example.com',
            'password' => 'wrong-password',
        ])->assertUnauthorized();
    }

    /**
     * Test login validates payload.
     *
     * @return void
     */
    public function test_login_validates_required_fields(): void
    {
        $this->postJson('/api/auth/login', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['email', 'password']);
    }

    /**
     * Test pending user login is blocked.
     */
    public function test_pending_user_cannot_login(): void
    {
        User::factory()->withoutTwoFactor()->pendingApproval()->create([
            'email' => 'pending@example.com',
            'password' => Hash::make('password'),
        ]);

        $this->postJson('/api/auth/login', [
            'email' => 'pending@example.com',
            'password' => 'password',
        ])->assertForbidden();
    }

    /**
     * Test protected routes require tokens.
     */
    public function test_protected_route_requires_token(): void
    {
        $this->getJson('/api/auth/me')->assertUnauthorized();
    }

    /**
     * Test logout revokes the token.
     */
    public function test_user_can_logout_current_token(): void
    {
        $user = User::factory()->withoutTwoFactor()->create();
        $token = $user->createToken('api')->plainTextToken;

        $this->withToken($token)
            ->postJson('/api/auth/logout')
            ->assertOk()
            ->assertJsonPath('message', 'Logged out.');

        $this->assertDatabaseCount('personal_access_tokens', 0);
    }

    /**
     * Test authenticated user can update password.
     *
     * @return void
     */
    public function test_user_can_update_password(): void
    {
        $user = User::factory()->withoutTwoFactor()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user, 'sanctum')
            ->putJson('/api/auth/password', [
                'current_password' => 'old-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])
            ->assertOk()
            ->assertJsonPath('message', 'Password updated.');

        $user->refresh();

        $this->assertTrue(Hash::check('new-password', $user->password));
    }

    /**
     * Test password update validates payload.
     *
     * @return void
     */
    public function test_password_update_validates_payload(): void
    {
        $user = User::factory()->withoutTwoFactor()->create([
            'password' => Hash::make('old-password'),
        ]);

        $this->actingAs($user, 'sanctum')
            ->putJson('/api/auth/password', [
                'password' => 'short',
            ])
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['current_password', 'password']);
    }
}
