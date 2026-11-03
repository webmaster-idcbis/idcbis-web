<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\Post;
use App\Models\User;
use App\Support\PostCategories;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /** Noticias de ejemplo que esta carga reemplaza. */
    private const LEGACY_SLUGS = [
        'idcbis-fortalece-investigacion-terapias-avanzadas',
        'campana-donacion-sangre-marzo-2025',
        'convenio-red-tejidos-2025',
        'reconocimiento-talento-humano-idcbis',
        'apropiacion-social-talleres-comunidad',
        'avances-celulas-progenitoras-hematopoyeticas',
        'congreso-nacional-biotecnologia',
        'jornada-donacion-tejidos',
        'llamado-donacion-ciudadania',
        'renovacion-servicio-irradiacion',
    ];

    public function run(): void
    {
        $user = User::query()->where('email', 'admin@idcbis.gov.co')->first()
            ?? User::query()->first();

        if (! $user) {
            if ($this->command) {
                $this->command->error('No hay usuarios. Ejecuta: php artisan db:seed');
            }

            return;
        }

        $postsFile = database_path('data/noticias-posts.php');
        if (! is_file($postsFile)) {
            return;
        }

        /** @var array<int, array<string, string>> $posts */
        $posts = require $postsFile;
        usort($posts, static fn (array $a, array $b) => strcmp($b['published_at'], $a['published_at']));

        foreach ($posts as $item) {
            $post = Post::withTrashed()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'category' => $item['category'],
                    'featured_image' => $item['image'],
                    'status' => 'published',
                    'meta_title' => $item['title'],
                    'meta_description' => $item['excerpt'],
                    'published_at' => $item['published_at'],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                ]
            );

            if ($post->trashed()) {
                $post->restore();
            }
        }

        Post::query()->whereIn('slug', self::LEGACY_SLUGS)->delete();

        $this->syncHomeFeaturedNews(array_slice($posts, 0, 3));

        if ($this->command) {
            $this->command->info('Noticias publicadas con contenido completo: '.count($posts));
        }
    }

    /**
     * @param  array<int, array<string, string>>  $featured
     */
    private function syncHomeFeaturedNews(array $featured): void
    {
        $page = Page::query()->where('slug', 'inicio')->first();
        if (! $page || ! is_array($page->content)) {
            return;
        }

        $cards = array_map(fn (array $post) => [
            'id' => $post['id'],
            'slug' => $post['slug'],
            'image' => $post['image'],
            'imageAlt' => $post['title'],
            'category' => PostCategories::label($post['category']),
            'title' => $post['title'],
            'excerpt' => $post['excerpt'] ?? '',
            'date' => $post['published_label'],
        ], $featured);

        $content = $page->content;
        $updated = false;

        foreach ($content as &$block) {
            if (($block['type'] ?? '') === 'idcbis-news-press') {
                $block['news'] = $cards;
                $updated = true;
            }
        }
        unset($block);

        if (! $updated) {
            return;
        }

        $page->content = $content;
        $page->save();
    }
}
