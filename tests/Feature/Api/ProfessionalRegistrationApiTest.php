<?php

namespace Tests\Feature\Api;

use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class ProfessionalRegistrationApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test a professional can register with a KBIS file.
     *
     * @return void
     */
    public function test_professional_can_register_with_kbis_file(): void
    {
        Role::create(['name' => 'user']);

        $response = $this->post('/api/client/register-request', [
            'first_name' => 'Alice',
            'last_name' => 'Martin',
            'email' => 'alice@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'phone' => '0102030405',
            'company_name' => 'Boulangerie Martin',
            'legal_status' => 'SARL',
            'siret' => '12345678900011',
            'company_email' => 'contact@martin.fr',
            'company_phone' => '0102030406',
            'kbis_file' => UploadedFile::fake()->create('kbis.pdf', 100, 'application/pdf'),
        ]);

        $response
            ->assertCreated()
            ->assertJsonPath('message', 'Registration request submitted and awaiting approval.')
            ->assertJsonPath('user.email', 'alice@example.com');

        $this->assertDatabaseHas('users', [
            'email' => 'alice@example.com',
            'is_active' => null,
        ]);

        $this->assertDatabaseHas('stores', [
            'name' => 'Boulangerie Martin',
            'siret' => '12345678900011',
        ]);

        $this->assertDatabaseCount('files', 1);
    }
}
