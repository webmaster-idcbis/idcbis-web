<?php

namespace Tests\Feature;

use App\Support\MergePageContent;
use App\Support\SplitPageContent;
use Tests\TestCase;

class SyncPageDataFilesTest extends TestCase
{
    /** @test */
    public function documents_page_round_trips_through_split_and_merge(): void
    {
        $monolith = require database_path('data/plan-anticorrupcion-page.php');
        $split = SplitPageContent::split([$monolith]);
        $merged = MergePageContent::mergeDocumentsPage($split);

        $this->assertNotNull($merged);
        $this->assertSame($monolith['heroTitle'], $merged['heroTitle']);
        $this->assertSame($monolith['eyebrow'], $merged['eyebrow']);
        $this->assertSame($monolith['intro'], $merged['intro']);
        $this->assertSame(count($monolith['groups']), count($merged['groups']));
        $this->assertSame(
            $monolith['groups'][0]['documents'][0]['title'],
            $merged['groups'][0]['documents'][0]['title'],
        );
    }

    /** @test */
    public function rendicion_de_cuentas_page_file_matches_split_content(): void
    {
        $monolith = require database_path('data/rendicion-de-cuentas-page.php');
        $content = SplitPageContent::split([$monolith]);
        $merged = MergePageContent::mergeDocumentsPage($content);

        $this->assertSame('2025', $merged['groups'][0]['label']);
        $this->assertSame('Calendario', $merged['groups'][count($merged['groups']) - 1]['label']);
    }

    /** @test */
    public function parse_hero_subtitle_splits_eyebrow_and_subtitle(): void
    {
        [$eyebrow, $subtitle] = MergePageContent::parseHeroSubtitle("Información pública\nConsulta los informes.");

        $this->assertSame('Información pública', $eyebrow);
        $this->assertSame('Consulta los informes.', $subtitle);
    }
}
