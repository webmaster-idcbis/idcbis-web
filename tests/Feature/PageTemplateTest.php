<?php

namespace Tests\Feature;

use App\Models\PageTemplate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageTemplateTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    /** @test */
    public function can_list_page_templates(): void
    {
        PageTemplate::factory()->count(2)->create(['created_by' => $this->user->id]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->getJson('/api/page-templates');

        $response->assertOk()
            ->assertJsonCount(2, 'data');
    }

    /** @test */
    public function can_save_page_as_template(): void
    {
        $payload = [
            'name' => 'Plantilla Servicios',
            'description' => 'Base para páginas de servicios',
            'content' => [
                [
                    'id' => 'element_1',
                    'type' => 'heading',
                    'content' => 'Servicios',
                    'level' => 'h1',
                ],
            ],
            'meta_title' => 'Servicios',
            'meta_description' => 'Descripción de servicios',
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/page-templates', $payload);

        $response->assertCreated()
            ->assertJsonPath('data.name', 'Plantilla Servicios')
            ->assertJsonPath('message', 'Plantilla guardada exitosamente');

        $this->assertDatabaseHas('page_templates', [
            'name' => 'Plantilla Servicios',
            'slug' => 'plantilla-servicios',
            'is_system' => false,
        ]);
    }

    /** @test */
    public function cannot_delete_system_template(): void
    {
        $template = PageTemplate::factory()->system()->create([
            'created_by' => $this->user->id,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/page-templates/{$template->id}");

        $response->assertForbidden();
        $this->assertDatabaseHas('page_templates', ['id' => $template->id]);
    }

    /** @test */
    public function can_delete_user_template(): void
    {
        $template = PageTemplate::factory()->create([
            'created_by' => $this->user->id,
            'is_system' => false,
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->deleteJson("/api/page-templates/{$template->id}");

        $response->assertOk();
        $this->assertDatabaseMissing('page_templates', ['id' => $template->id]);
    }
}
