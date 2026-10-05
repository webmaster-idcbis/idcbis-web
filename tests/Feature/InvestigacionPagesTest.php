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
        $this->assertCount(5, $links);
        $this->assertSame('/investigacion-terapias-avanzadas', $links[0]['url'] ?? null);
        $this->assertSame('Unidad de Terapias Avanzadas', $links[0]['label'] ?? null);
        $this->assertSame('/investigacion-celulas-progenitoras-hematopoyeticas', $links[1]['url'] ?? null);
        $this->assertSame('/investigacion-medicina-transfusional', $links[2]['url'] ?? null);
        $this->assertNotContains('idcbis-line-cards', $types);
    }

    /** @test */
    public function uta_section_links_to_four_lines()
    {
        $uta = require database_path('data/investigacion-terapias-avanzadas-content.php');
        $links = collect($uta)->firstWhere('type', 'idcbis-links')['links'] ?? [];

        $this->assertSame('hero', $uta[0]['type'] ?? null);
        $this->assertCount(4, $links);
        $this->assertSame('/investigacion-neurociencias', $links[0]['url'] ?? null);
        $this->assertSame('Neurociencias', $links[0]['label'] ?? null);
        $this->assertSame('/investigacion-ingenieria-tisular', $links[1]['url'] ?? null);
        $this->assertSame('Ingeniería tisular', $links[1]['label'] ?? null);
        $this->assertSame('/investigacion-innovacion-produccion', $links[2]['url'] ?? null);
        $this->assertSame('Innovación y producción', $links[2]['label'] ?? null);
        $this->assertSame('/investigacion-inmunoterapia', $links[3]['url'] ?? null);
        $this->assertSame('Inmunoterapia', $links[3]['label'] ?? null);
        $this->assertNotContains('idcbis-line-cards', array_column($uta, 'type'));
    }

    /** @test */
    public function cph_and_transfusional_content_have_expected_blocks()
    {
        $cph = require database_path('data/investigacion-celulas-progenitoras-hematopoyeticas-content.php');
        $imt = require database_path('data/investigacion-medicina-transfusional-content.php');
        $neu = require database_path('data/investigacion-neurociencias-content.php');

        $this->assertSame('carousel', $cph[0]['type'] ?? null);
        $this->assertContains('accordion', array_column($cph, 'type'));
        $this->assertContains('process-timeline', array_column($cph, 'type'));

        $this->assertSame('carousel', $imt[0]['type'] ?? null);
        $this->assertContains('dual-panel', array_column($imt, 'type'));
        $this->assertContains('process-timeline', array_column($imt, 'type'));

        $this->assertSame('carousel', $neu[0]['type'] ?? null);
        $this->assertSame('Neurociencias', $neu[0]['slides'][0]['title'] ?? null);
        $this->assertNotContains('idcbis-links', array_column($neu, 'type'));
        $this->assertNotContains('idcbis-line-cards', array_column($neu, 'type'));
        $this->assertContains('idcbis-team-grid', array_column($neu, 'type'));
        $this->assertNotContains('accordion', array_column($neu, 'type'));
        $this->assertNotContains('idcbis-info-grid', array_column($neu, 'type'));

        $projectUrls = collect($neu)->firstWhere('id', 'neu_proyectos')['cards'] ?? [];
        $this->assertCount(7, $projectUrls);
        foreach ($projectUrls as $card) {
            $slug = ltrim($card['url'] ?? '', '/');
            $project = require database_path("data/{$slug}-content.php");
            $this->assertSame($card['title'], $project[0]['slides'][0]['title'] ?? null, $slug);
        }
    }

    /** @test */
    public function meta_descriptions_respect_seo_limit()
    {
        foreach ([
            'investigacion',
            'investigacion-terapias-avanzadas',
            'investigacion-celulas-progenitoras-hematopoyeticas',
            'investigacion-medicina-transfusional',
            'investigacion-neurociencias',
            'investigacion-neurociencias-trauma-raquimedular',
            'investigacion-neurociencias-cannabis-terapeutico',
            'investigacion-neurociencias-biomarcadores-alzheimer',
            'investigacion-neurociencias-progenitores-neurales',
            'investigacion-neurociencias-bioensambles-parkinson',
            'investigacion-neurociencias-isquemia-cerebral',
            'investigacion-neurociencias-injerto-nervioso-acelular',
            'investigacion-ingenieria-tisular',
            'investigacion-innovacion-produccion',
            'investigacion-inmunoterapia',
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
        $this->seed(\Database\Seeders\InvestigacionTerapiasAvanzadasPageSeeder::class);
        $this->seed(\Database\Seeders\InvestigacionNeurocienciasPageSeeder::class);

        foreach ([
            'investigacion',
            'investigacion-celulas-progenitoras-hematopoyeticas',
            'investigacion-medicina-transfusional',
            'investigacion-terapias-avanzadas',
            'investigacion-neurociencias',
            'investigacion-neurociencias-trauma-raquimedular',
            'investigacion-neurociencias-cannabis-terapeutico',
            'investigacion-neurociencias-biomarcadores-alzheimer',
            'investigacion-neurociencias-progenitores-neurales',
            'investigacion-neurociencias-bioensambles-parkinson',
            'investigacion-neurociencias-isquemia-cerebral',
            'investigacion-neurociencias-injerto-nervioso-acelular',
            'investigacion-ingenieria-tisular',
            'investigacion-innovacion-produccion',
            'investigacion-inmunoterapia',
        ] as $slug) {
            $this->assertDatabaseHas('pages', ['slug' => $slug, 'status' => 'published']);
        }
    }
}
