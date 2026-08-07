<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_posts_index_returns_only_published_posts()
    {
        $user = User::factory()->create();
        Post::factory()->for($user, 'creator')->published()->create(['title' => 'Publicada']);
        Post::factory()->for($user, 'creator')->create(['title' => 'Borrador']);

        $response = $this->getJson('/api/posts?paginate=1');

        $response->assertOk()
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.title', 'Publicada');
    }

    /** @test */
    public function authenticated_user_can_create_post()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/posts', [
            'title' => 'Nueva noticia de prueba',
            'excerpt' => 'Resumen breve',
            'content' => '<p>Contenido</p>',
            'category' => 'investigacion',
            'status' => 'draft',
        ]);

        $response->assertCreated()
            ->assertJsonPath('data.title', 'Nueva noticia de prueba');

        $this->assertDatabaseHas('posts', [
            'slug' => 'nueva-noticia-de-prueba',
            'status' => 'draft',
        ]);
    }

    /** @test */
    public function public_can_view_post_by_slug()
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user, 'creator')->published()->create([
            'slug' => 'noticia-publica',
            'title' => 'Noticia pública',
        ]);

        $response = $this->getJson('/api/posts/slug/'.$post->slug);

        $response->assertOk()
            ->assertJsonPath('data.title', 'Noticia pública')
            ->assertJsonPath('data.slug', 'noticia-publica');
    }

    /** @test */
    public function admin_posts_list_includes_drafts()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        Post::factory()->for($user, 'creator')->published()->create();
        Post::factory()->for($user, 'creator')->create();

        $response = $this->getJson('/api/admin/posts');

        $response->assertOk()->assertJsonCount(2, 'data');
    }

    /** @test */
    public function post_can_be_saved_with_custom_published_at()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $response = $this->postJson('/api/posts', [
            'title' => 'Noticia con fecha personalizada',
            'excerpt' => 'Resumen',
            'content' => '<p>Contenido</p>',
            'category' => 'investigacion',
            'status' => 'published',
            'published_at' => '2024-06-15 10:30:00',
        ]);

        $response->assertCreated();
        $this->assertDatabaseHas('posts', [
            'slug' => 'noticia-con-fecha-personalizada',
            'status' => 'published',
        ]);

        $post = Post::first();
        $this->assertSame('2024-06-15 10:30:00', $post->published_at->format('Y-m-d H:i:s'));
    }

    /** @test */
    public function future_published_post_is_hidden_from_public_list()
    {
        $user = User::factory()->create();
        Post::factory()->for($user, 'creator')->create([
            'status' => 'published',
            'published_at' => now()->addDay(),
        ]);

        $this->getJson('/api/posts?paginate=1')
            ->assertOk()
            ->assertJsonCount(0, 'data');
    }

    /** @test */
    public function can_save_post_with_embedded_featured_image()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $png = base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8z8BQDwAEhQGAhKmMIQAAAABJRU5ErkJggg==');
        $imageData = 'data:image/png;base64,'.base64_encode($png);

        $response = $this->post('/api/posts', [
            'payload' => json_encode([
                'title' => 'Noticia con imagen',
                'excerpt' => 'Resumen',
                'content' => '<p>Texto</p>',
                'category' => 'investigacion',
                'status' => 'draft',
                'featured_image' => $imageData,
            ]),
        ], ['Accept' => 'application/json']);

        $response->assertCreated();

        $post = Post::first();
        $this->assertSame('Noticia con imagen', $post->title);
        $this->assertSame('<p>Texto</p>', $post->content);
        $this->assertStringStartsWith('/uploads/posts/', $post->featured_image);
        $this->assertFileExists(public_path(ltrim($post->featured_image, '/')));
    }
}
