<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SitemapXmlTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function sitemap_lists_published_pages_and_visible_posts(): void
    {
        $user = User::factory()->create();

        Page::factory()->published()->create([
            'slug' => 'inicio',
            'title' => 'Inicio',
            'no_index' => false,
        ]);
        Page::factory()->published()->create([
            'slug' => 'quienes-somos',
            'no_index' => false,
        ]);
        Page::factory()->published()->create([
            'slug' => 'oculta',
            'no_index' => true,
        ]);
        Page::factory()->draft()->create(['slug' => 'borrador']);

        Post::factory()->for($user, 'creator')->published()->create([
            'slug' => 'noticia-visible',
        ]);
        Post::factory()->for($user, 'creator')->create([
            'slug' => 'noticia-futura',
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $this->assertStringContainsString('xml', (string) $response->headers->get('Content-Type'));
        $response->assertSee('/quienes-somos', false);
        $response->assertSee('/noticias/noticia-visible', false);
        $response->assertDontSee('/oculta', false);
        $response->assertDontSee('/borrador', false);
        $response->assertDontSee('noticia-futura', false);
    }

    /** @test */
    public function robots_txt_points_to_the_sitemap(): void
    {
        $response = $this->get('/robots.txt');

        $response->assertOk();
        $response->assertSee('User-agent: *', false);
        $response->assertSee('Sitemap:', false);
        $response->assertSee('/sitemap.xml', false);
    }
}
