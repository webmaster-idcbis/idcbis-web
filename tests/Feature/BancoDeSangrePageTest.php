<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\BancoDeSangrePageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BancoDeSangrePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function banco_de_sangre_content_has_conversion_blocks(): void
    {
        $content = require database_path('data/banco-de-sangre-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(10, count($content));

        $types = array_column($content, 'type');
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);
        $this->assertContains('idcbis-checklist', $types);
        $this->assertContains('process-timeline', $types);
        $this->assertContains('idcbis-card-grid', $types);
        $this->assertContains('idcbis-info-grid', $types);
        $this->assertContains('cta-banner', $types);

        $ctaCount = preg_match_all('/agendar/i', json_encode($content, JSON_UNESCAPED_UNICODE));
        $this->assertGreaterThanOrEqual(4, $ctaCount);
    }

    /** @test */
    public function banco_de_sangre_hero_has_primary_and_maps_ctas(): void
    {
        $content = require database_path('data/banco-de-sangre-content.php');
        $hero = $content[0];
        $slide = $hero['slides'][0] ?? [];

        $this->assertSame('Dona sangre, salva vidas', $slide['title'] ?? null);
        $this->assertSame('Agendar donación', $slide['buttonText'] ?? null);
        $this->assertSame('tel:+5713649620', $slide['buttonUrl'] ?? null);
    }

    /** @test */
    public function banco_de_sangre_types_section_has_visible_items(): void
    {
        $content = require database_path('data/banco-de-sangre-content.php');
        $types = collect($content)->firstWhere('type', 'idcbis-card-grid');

        $this->assertNotEmpty($types['items'] ?? []);
        $this->assertGreaterThanOrEqual(3, count($types['items']));
        $this->assertNotEmpty($types['items'][0]['title'] ?? null);
        $this->assertNotEmpty($types['items'][0]['description'] ?? null);
        $this->assertNotEmpty($types['items'][0]['duration'] ?? null);
        $this->assertNotEmpty($types['items'][0]['frequency'] ?? null);
    }

    /** @test */
    public function banco_de_sangre_meta_description_respects_seo_limit(): void
    {
        $meta = require database_path('data/banco-de-sangre-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function banco_de_sangre_seeder_creates_cms_page(): void
    {
        User::factory()->create();

        $this->seed(BancoDeSangrePageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'banco-de-sangre',
            'status' => 'published',
        ]);

        $page = Page::where('slug', 'banco-de-sangre')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('carousel', $page->content[0]['type'] ?? null);
    }
}
