<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DarCelulasPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function darcelulas_content_data_has_expected_blocks()
    {
        $content = require database_path('data/darcelulas-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(8, count($content));
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('process-timeline', $types);
        $this->assertContains('dual-panel', $types);
        $this->assertContains('accordion', $types);
        $this->assertContains('cta-banner', $types);
    }

    /** @test */
    public function darcelulas_content_uses_official_registration_url()
    {
        $content = require database_path('data/darcelulas-content.php');
        $encoded = json_encode($content, JSON_UNESCAPED_UNICODE);

        $this->assertStringContainsString('idcbis.darcelulas.com.co/preinscribete', $encoded);
        $this->assertStringContainsString('captacionregistro@idcbis.org.co', $encoded);
    }

    /** @test */
    public function darcelulas_meta_description_respects_seo_limit()
    {
        $meta = require database_path('data/darcelulas-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function darcelulas_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\DarCelulasPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'darcelulas',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'darcelulas')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('carousel', $page->content[0]['type'] ?? null);
    }
}
