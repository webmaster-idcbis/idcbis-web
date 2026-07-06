<?php

namespace Tests\Feature;

use App\Support\SplitPageContent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SplitPageContentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function quienes_somos_splits_into_multiple_blocks(): void
    {
        $monolith = require database_path('data/quienes-somos-page.php');
        $split = SplitPageContent::split([$monolith]);

        $this->assertGreaterThan(5, count($split));
        $this->assertNotContains('idcbis-quienes-somos', array_column($split, 'type'));
        $this->assertContains('hero', array_column($split, 'type'));
        $this->assertContains('idcbis-team-grid', array_column($split, 'type'));
    }

    /** @test */
    public function documents_page_splits_into_hero_intro_and_list(): void
    {
        $monolith = require database_path('data/plan-anticorrupcion-page.php');
        $split = SplitPageContent::split([$monolith]);

        $this->assertCount(3, $split);
        $this->assertSame('hero', $split[0]['type']);
        $this->assertSame('text', $split[1]['type']);
        $this->assertSame('idcbis-documents-list', $split[2]['type']);
    }

    /** @test */
    public function content_data_files_use_expected_format(): void
    {
        $quienes = require database_path('data/quienes-somos-content.php');
        $estados = require database_path('data/estados-financieros-content.php');
        $mapa = require database_path('data/mapa-del-sitio-content.php');

        $this->assertCount(1, $quienes);
        $this->assertSame('idcbis-quienes-somos', $quienes[0]['type'] ?? null);
        $this->assertSame('idcbis-documents-list', $estados[2]['type'] ?? null);
        $this->assertCount(2, $mapa);
    }
}
