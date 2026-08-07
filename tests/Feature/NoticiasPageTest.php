<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NoticiasPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function noticias_content_data_has_hero_news_list_and_carousel_blocks()
    {
        $content = require database_path('data/noticias-content.php');

        $this->assertIsArray($content);
        $this->assertCount(3, $content);
        $this->assertSame('hero', $content[0]['type'] ?? null);
        $this->assertSame('idcbis-news-list', $content[1]['type'] ?? null);
        $this->assertSame('idcbis-news-carousel', $content[2]['type'] ?? null);
        $this->assertNotEmpty($content[1]['items'] ?? []);
        $this->assertNotEmpty($content[2]['items'] ?? []);
    }

    /** @test */
    public function noticias_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\NoticiasPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'noticias',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'noticias')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('idcbis-news-list', $page->content[1]['type'] ?? null);
        $this->assertSame('idcbis-news-carousel', $page->content[2]['type'] ?? null);
    }
}
