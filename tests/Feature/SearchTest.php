<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_search_finds_content_in_published_pages()
    {
        Page::factory()->published()->create([
            'title' => 'Banco de Sangre',
            'slug' => 'banco-de-sangre',
            'meta_description' => 'Información sobre donación',
            'content' => [
                [
                    'id' => 'text_1',
                    'type' => 'text',
                    'content' => 'La donación de sangre salva vidas en Bogotá.',
                ],
            ],
            'sections' => [],
        ]);

        Page::factory()->draft()->create([
            'title' => 'Borrador secreto',
            'slug' => 'borrador-secreto',
            'content' => [
                ['id' => 't1', 'type' => 'text', 'content' => 'donación confidencial'],
            ],
        ]);

        $response = $this->getJson('/api/search?q=donación');

        $response->assertOk()
            ->assertJsonPath('meta.total', 1)
            ->assertJsonPath('data.0.slug', 'banco-de-sangre')
            ->assertJsonPath('data.0.title', 'Banco de Sangre');
    }

    /** @test */
    public function search_requires_at_least_two_characters()
    {
        Page::factory()->published()->create([
            'title' => 'Contacto',
            'slug' => 'contacto',
        ]);

        $this->getJson('/api/search?q=a')
            ->assertOk()
            ->assertJsonPath('meta.total', 0);
    }

    /** @test */
    public function search_excludes_pages_marked_no_index()
    {
        Page::factory()->published()->create([
            'title' => 'Página privada',
            'slug' => 'pagina-privada',
            'no_index' => true,
            'content' => [
                ['id' => 't1', 'type' => 'text', 'content' => 'contenido reservado interno'],
            ],
        ]);

        $this->getJson('/api/search?q=reservado')
            ->assertOk()
            ->assertJsonPath('meta.total', 0);
    }

    /** @test */
    public function search_text_is_built_when_page_is_saved()
    {
        $user = User::factory()->create();

        $page = Page::factory()->published()->create([
            'title' => 'Servicios médicos',
            'slug' => 'servicios',
            'content' => [
                ['id' => 'h1', 'type' => 'heading', 'content' => 'Trasplante de médula'],
            ],
            'sections' => [],
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        $this->assertNotNull($page->search_text);
        $this->assertStringContainsString('Trasplante de médula', $page->search_text);
        $this->assertStringContainsString('Servicios médicos', $page->search_text);
    }
}
