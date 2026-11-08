<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OmiMedPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function omimed_content_data_has_expected_blocks()
    {
        $content = require database_path('data/omimed-content.php');

        $this->assertIsArray($content);
        $this->assertGreaterThanOrEqual(5, count($content));
        $this->assertSame('carousel', $content[0]['type'] ?? null);
        $this->assertSame('OmiMed', $content[0]['slides'][0]['title'] ?? null);

        $types = array_column($content, 'type');
        $this->assertContains('stats-grid', $types);
        $this->assertContains('dual-panel', $types);
        $this->assertContains('accordion', $types);
        $this->assertContains('cta-banner', $types);
    }

    /** @test */
    public function omimed_meta_description_respects_seo_limit()
    {
        $meta = require database_path('data/omimed-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function omimed_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\OmiMedPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'omimed',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'omimed')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('carousel', $page->content[0]['type'] ?? null);
    }
}
