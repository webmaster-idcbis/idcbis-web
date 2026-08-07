<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BancoDistritalDeTejidosPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function tejidos_content_data_has_hero_stats_and_team_blocks()
    {
        $content = require database_path('data/banco-distrital-de-tejidos-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(8, count($content));
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('process-timeline', $types);
        $this->assertContains('dual-panel', $types);
        $this->assertContains('idcbis-team-grid', $types);
        $this->assertContains('cta-banner', $types);
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
    }
}
