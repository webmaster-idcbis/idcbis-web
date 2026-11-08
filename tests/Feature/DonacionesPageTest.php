<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Database\Seeders\DonacionesPageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonacionesPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function donaciones_hub_offers_blood_and_tissue_paths(): void
    {
        $content = require database_path('data/donaciones-content.php');
        $hub = $content[0] ?? [];

        $this->assertSame('idcbis-donations-hub', $hub['type'] ?? null);
        $this->assertTrue($hub['fullBleed'] ?? false);
        $this->assertCount(2, $hub['paths'] ?? []);

        $urls = array_column($hub['paths'], 'url');
        $this->assertSame('/banco-de-sangre', $urls[0] ?? null);
        $this->assertSame('/banco-distrital-de-tejidos#donacion', $urls[1] ?? null);
        $this->assertNotEmpty($hub['paths'][0]['cta'] ?? null);
        $this->assertNotEmpty($hub['paths'][1]['cta'] ?? null);
        $this->assertCount(4, $hub['values'] ?? []);
    }

    /** @test */
    public function donaciones_meta_description_respects_seo_limit(): void
    {
        $meta = require database_path('data/donaciones-meta.php');

        $this->assertLessThanOrEqual(160, mb_strlen($meta['meta_description'] ?? ''));
    }

    /** @test */
    public function donaciones_seeder_creates_cms_page(): void
    {
        User::factory()->create();

        $this->seed(DonacionesPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'donaciones',
            'status' => 'published',
        ]);

        $page = Page::query()->where('slug', 'donaciones')->first();
        $this->assertSame('idcbis-donations-hub', $page->content[0]['type'] ?? null);
    }
}
