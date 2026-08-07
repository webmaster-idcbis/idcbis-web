<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UnidadDeTerapiasAvanzadasPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function uta_content_data_has_hero_stats_omimed_and_team_blocks()
    {
        $content = require database_path('data/unidad-de-terapias-avanzadas-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(8, count($content));
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('dual-panel', $types);
        $this->assertContains('process-timeline', $types);
        $this->assertContains('idcbis-team-grid', $types);
        $this->assertContains('cta-banner', $types);
    }

    /** @test */
    public function uta_meta_description_respects_seo_limit()
    {
        $meta = require database_path('data/unidad-de-terapias-avanzadas-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function uta_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\UnidadDeTerapiasAvanzadasPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'unidad-de-terapias-avanzadas',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'unidad-de-terapias-avanzadas')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('carousel', $page->content[0]['type'] ?? null);
    }
}
