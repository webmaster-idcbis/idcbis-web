<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sitemap_pages_data_has_unique_slugs()
    {
        $pages = require database_path('data/sitemap-pages.php');
        $slugs = array_column($pages, 'slug');

        $this->assertCount(count($slugs), array_unique($slugs));
    }

    /** @test */
    public function sitemap_pages_data_includes_core_sections()
    {
        $pages = require database_path('data/sitemap-pages.php');
        $slugs = array_column($pages, 'slug');

        $this->assertContains('quienes-somos', $slugs);
        $this->assertContains('servicios', $slugs);
        $this->assertContains('banco-de-sangre', $slugs);
        $this->assertContains('banco-distrital-de-tejidos', $slugs);
        $this->assertContains('transparencia', $slugs);
        $this->assertContains('contacto', $slugs);
    }

    /** @test */
    public function mapa_del_sitio_seeder_creates_cms_page()
    {
        $user = \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\MapaDelSitioPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'mapa-del-sitio',
            'title' => 'Mapa del sitio',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'mapa-del-sitio')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('sitemap', $page->content[0]['type'] ?? null);
    }
}
