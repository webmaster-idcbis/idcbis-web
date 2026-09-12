<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InvestigacionPagesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function hub_content_has_hero_stats_lines_and_cta()
    {
        $content = require database_path('data/investigacion-content.php');
        $types = array_column($content, 'type');

        $this->assertSame('hero', $content[0]['type'] ?? null);
        $this->assertContains('stats-grid', $types);
        $this->assertContains('idcbis-links', $types);
        $this->assertContains('cta-banner', $types);

        $links = collect($content)->firstWhere('type', 'idcbis-links')['links'] ?? [];
        $this->assertCount(6, $links);
        $this->assertSame('/unidad-de-terapias-avanzadas', $links[0]['url'] ?? null);
        $this->assertSame('/investigacion-celulas-progenitoras-hematopoyeticas', $links[2]['url'] ?? null);
        $this->assertSame('/investigacion-medicina-transfusional', $links[3]['url'] ?? null);
    }

    /** @test */
    public function cph_and_transfusional_content_have_expected_blocks()
    {
        $cph = require database_path('data/investigacion-celulas-progenitoras-hematopoyeticas-content.php');
        $imt = require database_path('data/investigacion-medicina-transfusional-content.php');

        $this->assertSame('carousel', $cph[0]['type'] ?? null);
        $this->assertContains('accordion', array_column($cph, 'type'));
        $this->assertContains('process-timeline', array_column($cph, 'type'));

        $this->assertSame('carousel', $imt[0]['type'] ?? null);
        $this->assertContains('dual-panel', array_column($imt, 'type'));
        $this->assertContains('process-timeline', array_column($imt, 'type'));
    }

    /** @test */
    public function meta_descriptions_respect_seo_limit()
    {
        foreach ([
            'investigacion',
            'investigacion-celulas-progenitoras-hematopoyeticas',
            'investigacion-medicina-transfusional',
        ] as $slug) {
            $meta = require database_path("data/{$slug}-meta.php");
            $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''), $slug);
        }
    }

    /** @test */
    public function seeders_create_published_cms_pages()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\InvestigacionPageSeeder::class);
        $this->seed(\Database\Seeders\InvestigacionCelulasProgenitorasPageSeeder::class);
        $this->seed(\Database\Seeders\InvestigacionMedicinaTransfusionalPageSeeder::class);

        $this->assertDatabaseHas('pages', ['slug' => 'investigacion', 'status' => 'published']);
        $this->assertDatabaseHas('pages', [
            'slug' => 'investigacion-celulas-progenitoras-hematopoyeticas',
            'status' => 'published',
        ]);
        $this->assertDatabaseHas('pages', [
            'slug' => 'investigacion-medicina-transfusional',
            'status' => 'published',
        ]);
    }
}
