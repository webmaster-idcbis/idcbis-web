<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\BancoPublicoSangreCordonUmbilicalPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BancoPublicoSangreCordonUmbilicalPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cordon_page_speaks_to_each_audience_and_leads_with_results(): void
    {
        $content = require database_path('data/banco-publico-sangre-cordon-umbilical-content.php');
        $encoded = json_encode($content, JSON_UNESCAPED_UNICODE);

        $this->assertIsArray($content);
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('stats-grid', $content[1]['type'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('idcbis-audiences', $types);
        $this->assertContains('idcbis-service-detail', $types);
        $this->assertContains('idcbis-card-grid', $types);
        $this->assertContains('idcbis-team-grid', $types);
        $this->assertNotContains('idcbis-checklist', $types);
        $this->assertNotContains('process-timeline', $types);

        $audiences = collect($content)->firstWhere('type', 'idcbis-audiences');
        $urls = array_column($audiences['cards'] ?? [], 'url');
        $this->assertSame(['#para-familias', '#servicios', '#investigacion'], $urls);

        $this->assertStringContainsString('98', $encoded);
        $this->assertStringContainsString('FACT-Netcord', $encoded);
        $this->assertStringContainsString('TRL-9', $encoded);
        $this->assertStringContainsString('https://www.youtube.com/watch?v=j77XcTWZxrM', $encoded);
        $this->assertStringContainsString('Programa Cordial', $encoded);
        $this->assertStringContainsString('https://www.aboutstemcells.org/donation-banking', $encoded);
        $this->assertStringNotContainsString('Ver el inventario', $encoded);
        $this->assertStringNotContainsString('Ver inventario', $encoded);
        $this->assertStringNotContainsString('Quiero donar', $encoded);
        $this->assertStringNotContainsString('¿Puedo donar?', $encoded);
    }

    /** @test */
    public function cordon_meta_description_respects_seo_limit(): void
    {
        $meta = require database_path('data/banco-publico-sangre-cordon-umbilical-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
        $this->assertNotSame('', $meta['meta_description'] ?? '');
    }

    /** @test */
    public function cordon_seeder_publishes_the_page(): void
    {
        User::factory()->create();

        $this->seed(BancoPublicoSangreCordonUmbilicalPageSeeder::class);

        $page = Page::where('slug', 'banco-publico-sangre-cordon-umbilical')->first();
        $this->assertNotNull($page);
        $this->assertSame('published', $page->status);
        $this->assertSame('idcbis-audiences', $page->content[2]['type'] ?? null);
    }
}
