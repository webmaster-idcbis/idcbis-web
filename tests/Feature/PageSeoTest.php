<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PageSeoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->token = $this->user->createToken('test-token')->plainTextToken;
    }

    /** @test */
    public function can_create_page_with_seo_fields()
    {
        $pageData = [
            'title' => 'Página SEO Test',
            'slug' => 'pagina-seo-test',
            'status' => 'published',
            'meta_title' => 'Título SEO Personalizado',
            'meta_description' => 'Descripción para SEO',
            'meta_keywords' => 'keyword1, keyword2, keyword3',
            'og_image' => 'https://ejemplo.com/imagen.jpg',
            'no_index' => false,
            'canonical_url' => 'https://sitio.com/canonical',
            'sections' => []
        ];

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', $pageData);

        $response->assertStatus(201)
            ->assertJsonPath('data.meta_title', 'Título SEO Personalizado')
            ->assertJsonPath('data.meta_keywords', 'keyword1, keyword2, keyword3')
            ->assertJsonPath('data.og_image', 'https://ejemplo.com/imagen.jpg')
            ->assertJsonPath('data.no_index', false)
            ->assertJsonPath('data.canonical_url', 'https://sitio.com/canonical');

        $this->assertDatabaseHas('pages', [
            'slug' => 'pagina-seo-test',
            'meta_title' => 'Título SEO Personalizado',
            'og_image' => 'https://ejemplo.com/imagen.jpg',
            'no_index' => false
        ]);
    }

    /** @test */
    public function can_update_page_seo_fields()
    {
        $page = Page::factory()->create([
            'meta_title' => 'Old Title',
            'meta_description' => 'Old Description',
            'no_index' => false
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/pages/{$page->id}", [
            'title' => $page->title,
            'slug' => $page->slug,
            'status' => $page->status,
            'meta_title' => 'New Title',
            'meta_description' => 'New Description',
            'meta_keywords' => 'new, keywords',
            'no_index' => true,
            'canonical_url' => 'https://new.com',
            'sections' => []
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.meta_title', 'New Title')
            ->assertJsonPath('data.no_index', true);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'meta_title' => 'New Title',
            'no_index' => true
        ]);
    }

    /** @test */
    public function seo_fields_are_optional()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Página Sin SEO',
            'slug' => 'pagina-sin-seo',
            'status' => 'draft',
            'sections' => []
        ]);

        $response->assertStatus(201)
            ->assertJsonPath('data.meta_title', null)
            ->assertJsonPath('data.meta_description', null);
    }

    /** @test */
    public function validates_meta_title_max_length()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test',
            'slug' => 'test-slug',
            'status' => 'draft',
            'meta_title' => str_repeat('a', 71), // 71 chars, max is 70
            'sections' => []
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['meta_title']);
    }

    /** @test */
    public function validates_meta_description_max_length()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test',
            'slug' => 'test-slug',
            'status' => 'draft',
            'meta_description' => str_repeat('a', 161), // 161 chars, max is 160
            'sections' => []
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['meta_description']);
    }

    /** @test */
    public function validates_canonical_url_format()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test',
            'slug' => 'test-slug',
            'status' => 'draft',
            'canonical_url' => 'not-a-valid-url',
            'sections' => []
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['canonical_url']);
    }

    /** @test */
    public function validates_og_image_url_format()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test',
            'slug' => 'test-slug',
            'status' => 'draft',
            'og_image' => 'invalid-url',
            'sections' => []
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['og_image']);
    }

    /** @test */
    public function no_index_accepts_boolean()
    {
        // Test with true
        $response1 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test 1',
            'slug' => 'test-1',
            'status' => 'draft',
            'no_index' => true,
            'sections' => []
        ]);
        $response1->assertStatus(201)->assertJsonPath('data.no_index', true);

        // Test with false
        $response2 = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->postJson('/api/pages', [
            'title' => 'Test 2',
            'slug' => 'test-2',
            'status' => 'draft',
            'no_index' => false,
            'sections' => []
        ]);
        $response2->assertStatus(201)->assertJsonPath('data.no_index', false);
    }

    /** @test */
    public function seo_fields_persisted_correctly_in_database()
    {
        $page = Page::factory()->create([
            'meta_title' => 'DB Test Title',
            'meta_description' => 'DB Test Description',
            'meta_keywords' => 'db, test, keywords',
            'og_image' => 'https://db.test/image.jpg',
            'no_index' => true,
            'canonical_url' => 'https://db.test/canonical'
        ]);

        $this->assertDatabaseHas('pages', [
            'id' => $page->id,
            'meta_title' => 'DB Test Title',
            'meta_keywords' => 'db, test, keywords',
            'og_image' => 'https://db.test/image.jpg',
            'no_index' => true,
            'canonical_url' => 'https://db.test/canonical'
        ]);

        // Retrieve and verify
        $retrieved = Page::find($page->id);
        $this->assertEquals('DB Test Title', $retrieved->meta_title);
        $this->assertEquals('db, test, keywords', $retrieved->meta_keywords);
        $this->assertEquals(1, $retrieved->no_index); // tinyint(1) en MySQL
    }

    /** @test */
    public function can_set_seo_fields_to_null()
    {
        $page = Page::factory()->create([
            'meta_title' => 'Existing Title',
            'canonical_url' => 'https://existing.com'
        ]);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
        ])->putJson("/api/pages/{$page->id}", [
            'title' => $page->title,
            'slug' => $page->slug,
            'status' => $page->status,
            'meta_title' => null,
            'canonical_url' => null,
            'sections' => []
        ]);

        $response->assertStatus(200)
            ->assertJsonPath('data.meta_title', null)
            ->assertJsonPath('data.canonical_url', null);
    }
}
