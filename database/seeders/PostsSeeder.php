<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
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

        $contentFile = database_path('data/noticias-content.php');
        if (! is_file($contentFile)) {
            return;
        }

        $content = require $contentFile;
        $listBlock = collect($content)->firstWhere('type', 'idcbis-news-list');
        $items = $listBlock['items'] ?? [];

        foreach ($items as $item) {
            Post::withTrashed()->updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'title' => $item['title'],
                    'excerpt' => $item['excerpt'] ?? '',
                    'content' => '<p>'.($item['excerpt'] ?? '').'</p>',
                    'category' => $item['category'] ?? 'sin-categoria',
                    'featured_image' => $item['image'] ?? null,
                    'status' => 'published',
                    'published_at' => now()->subDays(random_int(1, 90)),
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'deleted_at' => null,
                ]
            );
        }

        if ($this->command) {
            $this->command->info('Noticias de ejemplo creadas/actualizadas: '.count($items));
        }
    }
}
