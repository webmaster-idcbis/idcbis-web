<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BancoDistritalDeTejidosPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tejidos_content_data_has_hero_catalog_team_and_referents()
    {
        $content = require database_path('data/banco-distrital-de-tejidos-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(8, count($content));
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('idcbis-tissue-catalog', $types);
        $this->assertContains('process-timeline', $types);
        $this->assertContains('dual-panel', $types);
        $this->assertContains('idcbis-team-grid', $types);
        $this->assertContains('idcbis-links', $types);
        $this->assertContains('cta-banner', $types);

        $ids = array_column($content, 'id');
        $this->assertContains('portafolio', $ids);
        $this->assertContains('biblioteca', $ids);
        $this->assertContains('donacion', $ids);
    }

    /** @test */
    public function tejidos_catalog_covers_main_tissue_families_and_library()
    {
        $content = require database_path('data/banco-distrital-de-tejidos-content.php');
        $catalog = collect($content)->firstWhere('type', 'idcbis-tissue-catalog');

        $this->assertIsArray($catalog);
        $this->assertGreaterThanOrEqual(8, count($catalog['items'] ?? []));

        $categories = array_unique(array_column($catalog['items'], 'category'));
        $this->assertContains('osteomuscular', $categories);
        $this->assertContains('ocular', $categories);
        $this->assertContains('piel', $categories);
        $this->assertContains('membrana', $categories);

        $this->assertStringContainsString('bandetejidosycelulas@idcbis.org.co', $catalog['requestEmail'] ?? '');
        $this->assertStringContainsString('Portafolio-Banco-de-Tejidos.pdf', $catalog['pdfUrl'] ?? '');
    }

    /** @test */
    public function tejidos_page_includes_director_and_barcelona_referent()
    {
        $content = require database_path('data/banco-distrital-de-tejidos-content.php');
        $encoded = json_encode($content, JSON_UNESCAPED_UNICODE);

        $this->assertStringContainsString('Jhon Alexander Bello Sepúlveda', $encoded);
        $this->assertStringContainsString('jbello@idcbis.org.co', $encoded);
        $this->assertStringContainsString('bancsang.net', $encoded);
        $this->assertStringContainsString('Ley 1805', $encoded);
        $this->assertStringContainsString('Biblioteca digital de tejidos', $encoded);
    }

    /** @test */
    public function tejidos_meta_description_respects_seo_limit()
    {
        $meta = require database_path('data/banco-distrital-de-tejidos-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function tejidos_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\BancoDistritalDeTejidosPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'banco-distrital-de-tejidos',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'banco-distrital-de-tejidos')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('carousel', $page->content[0]['type'] ?? null);
        $this->assertContains('idcbis-tissue-catalog', array_column($page->content, 'type'));
    }
}
