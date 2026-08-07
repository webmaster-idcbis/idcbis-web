<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipaPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function participa_content_data_has_expected_blocks()
    {
        $content = require database_path('data/participa-content.php');

        $this->assertIsArray($content);
        $this->assertCount(2, $content);
        $this->assertSame('hero', $content[0]['type'] ?? null);
        $this->assertSame('accordion', $content[1]['type'] ?? null);
        $this->assertCount(3, $content[1]['items'] ?? []);

        foreach ($content[1]['items'] as $section) {
            $this->assertNotEmpty($section['links'] ?? [], "La sección {$section['id']} debe tener enlaces.");
        }
    }

    /** @test */
    public function participa_seeder_creates_cms_page()
    {
        \App\Models\User::factory()->create();

        $this->seed(\Database\Seeders\ParticipaPageSeeder::class);

        $this->assertDatabaseHas('pages', [
            'slug' => 'participa',
            'status' => 'published',
        ]);

        $page = \App\Models\Page::where('slug', 'participa')->first();
        $this->assertIsArray($page->content);
        $this->assertSame('accordion', $page->content[1]['type'] ?? null);
    }
}
