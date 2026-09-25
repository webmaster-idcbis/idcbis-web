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

        $this->assertCount(8, $content);

        $expected = [
            ['type' => 'idcbis-hero-carousel', 'blockLabel' => 'Hero principal (carrusel)'],
            ['type' => 'idcbis-services', 'blockLabel' => 'Grid de servicios'],
            ['type' => 'idcbis-audiences', 'blockLabel' => 'Accesos según tu perfil'],
            ['type' => 'idcbis-stats', 'blockLabel' => 'Cifras destacadas'],
            ['type' => 'idcbis-bubbles', 'blockLabel' => 'Programas de investigación'],
            ['type' => 'idcbis-about', 'blockLabel' => 'Somos IDCBIS'],
            ['type' => 'html', 'blockLabel' => 'Qué está pasando en Bogotá'],
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
        $this->assertCount(8, $page->content);
        $this->assertSame([], $page->sections);
        $this->assertSame(
            [
                'idcbis-hero-carousel',
                'idcbis-services',
                'idcbis-audiences',
                'idcbis-stats',
                'idcbis-bubbles',
                'idcbis-about',
                'html',
                'idcbis-contact',
            ],
            array_column($page->content, 'type')
        );
    }

    /** @test */
    public function inicio_hero_carousel_includes_service_page_banners(): void
    {
        $content = require database_path('data/propuesta-azul-content.php');
        $hero = $content[0];

        $this->assertFalse($hero['autoPlay']);
        $this->assertFalse($hero['showArrows']);
        $this->assertFalse($hero['showIndicators']);
        $this->assertCount(1, $hero['slides']);
        $this->assertSame('Ciencia que', $hero['slides'][0]['titleLight']);
        $this->assertSame('transforma vidas', $hero['slides'][0]['titleBold']);
        $this->assertSame('Quiero donar sangre', $hero['slides'][0]['button1Text']);
        $this->assertSame('/banco-de-sangre', $hero['slides'][0]['button1Url']);
        $this->assertSame('Registrarme en DarCélulas', $hero['slides'][0]['button2Text']);
        $this->assertSame('/darcelulas', $hero['slides'][0]['button2Url']);
        $this->assertSame('Conocer nuestros servicios', $hero['slides'][0]['button3Text']);
        $this->assertSame('#servicios', $hero['slides'][0]['button3Url']);
        $this->assertCount(3, $hero['quickAnswers']);
        $this->assertCount(3, $hero['visualFrames']);
        $this->assertStringNotContainsString('cordón', json_encode($hero, JSON_UNESCAPED_UNICODE));
    }

    /** @test */
    public function public_inicio_endpoint_returns_split_element_content(): void
    {
        User::factory()->create();
        $this->seed(PropuestaAzulPageSeeder::class);

        $this->getJson('/api/pages/slug/inicio')
            ->assertOk()
            ->assertJsonPath('data.slug', 'inicio')
            ->assertJsonCount(8, 'data.content')
            ->assertJsonPath('data.content.0.type', 'idcbis-hero-carousel')
            ->assertJsonPath('data.content.2.type', 'idcbis-audiences')
            ->assertJsonPath('data.content.6.type', 'html')
            ->assertJsonPath('data.content.7.type', 'idcbis-contact');
    }
}
