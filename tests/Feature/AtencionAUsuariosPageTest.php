<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AtencionAUsuariosPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function atencion_a_usuarios_content_data_has_expected_blocks()
    {
        $content = require database_path('data/atencion-a-usuarios-content.php');

        $this->assertIsArray($content);
        $this->assertCount(5, $content);
        $this->assertSame('hero', $content[0]['type'] ?? null);
        $this->assertSame('idcbis-links', $content[1]['type'] ?? null);
        $this->assertSame('dual-panel', $content[2]['type'] ?? null);
        $this->assertSame('idcbis-contact', $content[3]['type'] ?? null);
        $this->assertSame('cta-banner', $content[4]['type'] ?? null);
        $this->assertNotEmpty($content[1]['links'] ?? []);
        $this->assertNotEmpty($content[3]['items'] ?? []);
    }

    /** @test */
    public function atencion_a_usuarios_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\AtencionAUsuariosPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'atencion-a-usuarios',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'atencion-a-usuarios')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('idcbis-links', $page->content[1]['type'] ?? null);
    }
}
