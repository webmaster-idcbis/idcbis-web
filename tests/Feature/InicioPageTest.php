<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\PropuestaAzulPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InicioPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function inicio_page_content_is_split_into_six_editable_blocks(): void
    {
        $content = require database_path('data/propuesta-azul-content.php');

        $this->assertCount(6, $content);

        $expected = [
            ['type' => 'idcbis-hero-carousel', 'blockLabel' => 'Hero principal (carrusel)'],
            ['type' => 'idcbis-services', 'blockLabel' => 'Grid de servicios'],
            ['type' => 'idcbis-stats', 'blockLabel' => 'Cifras destacadas'],
            ['type' => 'idcbis-bubbles', 'blockLabel' => 'Programas de investigación'],
            ['type' => 'idcbis-about', 'blockLabel' => 'Somos IDCBIS'],
            ['type' => 'idcbis-contact', 'blockLabel' => 'Contacto'],
        ];

        foreach ($expected as $index => $block) {
            $this->assertSame($block['type'], $content[$index]['type']);
            $this->assertSame($block['blockLabel'], $content[$index]['blockLabel']);
            $this->assertNotEmpty($content[$index]['id']);
        }
    }

    /** @test */
    public function inicio_page_seeder_publishes_split_content_without_legacy_sections(): void
    {
        User::factory()->create();

        $this->seed(PropuestaAzulPageSeeder::class);

        $page = Page::query()->where('slug', 'inicio')->first();

        $this->assertNotNull($page);
        $this->assertSame('published', $page->status);
        $this->assertCount(6, $page->content);
        $this->assertSame([], $page->sections);
        $this->assertSame(
            [
                'idcbis-hero-carousel',
                'idcbis-services',
                'idcbis-stats',
                'idcbis-bubbles',
                'idcbis-about',
                'idcbis-contact',
            ],
            array_column($page->content, 'type')
        );
    }

    /** @test */
    public function public_inicio_endpoint_returns_split_element_content(): void
    {
        User::factory()->create();
        $this->seed(PropuestaAzulPageSeeder::class);

        $this->getJson('/api/pages/slug/inicio')
            ->assertOk()
            ->assertJsonPath('data.slug', 'inicio')
            ->assertJsonCount(6, 'data.content')
            ->assertJsonPath('data.content.0.type', 'idcbis-hero-carousel')
            ->assertJsonPath('data.content.5.type', 'idcbis-contact');
    }
}
