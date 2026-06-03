<?php

namespace Tests\Feature\Api;

use App\Models\Categorie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test company information is public.
     *
     * @return void
     */
    public function test_company_information_is_public(): void
    {
        $this->getJson('/api/public/company')
            ->assertOk()
            ->assertJsonStructure([
                'company' => ['name', 'location', 'activity', 'phone', 'email', 'suppliers'],
            ]);
    }

    /**
     * Test public categories are listed.
     *
     * @return void
     */
    public function test_public_categories_are_listed(): void
    {
        Categorie::create(['libelle' => 'Palets']);

        $this->getJson('/api/public/categories')
            ->assertOk()
            ->assertJsonPath('categories.0.libelle', 'Palets');
    }

    /**
     * Test contact messages can be sent.
     *
     * @return void
     */
    public function test_contact_messages_can_be_sent(): void
    {
        $this->postJson('/api/public/contact', [
            'name' => 'Jean Client',
            'email' => 'jean@example.com',
            'phone' => '0102030405',
            'company' => 'Magasin Test',
            'message' => 'Bonjour Ty Delice',
        ])
            ->assertCreated()
            ->assertJsonPath('message', 'Contact message sent.');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'jean@example.com',
        ]);
    }
}
