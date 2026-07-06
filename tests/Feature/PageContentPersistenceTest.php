<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageContentPersistenceTest extends TestCase
{
    use RefreshDatabase;

    private User $user;

    private string $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test')->plainTextToken;
    }

    /** @test */
    public function updated_content_is_returned_on_public_slug_endpoint(): void
    {
        $page = Page::factory()->published()->create([
            'slug' => 'estados-financieros',
            'content' => [
                [
                    'id' => 'ef_page',
                    'type' => 'idcbis-documents-page',
                    'heroTitle' => 'Título original',
                    'groups' => [],
                ],
            ],
            'sections' => [],
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $newContent = [
            [
                'id' => 'ef_page',
                'type' => 'idcbis-documents-page',
                'heroTitle' => 'Título actualizado',
                'groups' => [
                    [
                        'id' => 'g1',
                        'label' => 'Período prueba',
                        'documents' => [
                            ['id' => 'd1', 'title' => 'Documento A', 'publishedAt' => '01 Enero 2026', 'url' => ''],
                        ],
                    ],
                ],
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer '.$this->token])
            ->postJson("/api/pages/{$page->id}/save", [
                'content' => $newContent,
                'sections' => [],
                'status' => 'published',
            ])
            ->assertOk()
            ->assertJsonPath('content_saved', true)
            ->assertJsonPath('data.content.0.heroTitle', 'Título actualizado');

        $this->getJson('/api/pages/slug/estados-financieros')
            ->assertOk()
            ->assertJsonPath('data.content.0.heroTitle', 'Título actualizado')
            ->assertJsonPath('data.content.0.groups.0.label', 'Período prueba');
    }

    /** @test */
    public function multipart_payload_field_persists_content(): void
    {
        $page = Page::factory()->published()->create([
            'slug' => 'test-multipart',
            'content' => [],
            'sections' => [],
            'created_by' => $this->user->id,
            'updated_by' => $this->user->id,
        ]);

        $newContent = [
            [
                'id' => 'doc_page',
                'type' => 'idcbis-documents-page',
                'heroTitle' => 'Desde FormData',
                'groups' => [],
            ],
        ];

        $this->withHeaders(['Authorization' => 'Bearer '.$this->token])
            ->post("/api/pages/{$page->id}/save", [
                'payload' => json_encode([
                    'content' => $newContent,
                    'sections' => [],
                    'status' => 'published',
                ]),
            ])
            ->assertOk()
            ->assertJsonPath('content_saved', true)
            ->assertJsonPath('data.content.0.heroTitle', 'Desde FormData');
    }
}
