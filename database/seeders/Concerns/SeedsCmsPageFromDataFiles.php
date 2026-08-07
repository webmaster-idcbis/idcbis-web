<?php

namespace Database\Seeders\Concerns;

use App\Models\Page;
use App\Models\User;

trait SeedsCmsPageFromDataFiles
{
    protected function seedPageFromDataFiles(string $slug, array $defaults): ?Page
    {
        $user = User::query()->where('email', 'admin@idcbis.gov.co')->first()
            ?? User::query()->first();

        if (! $user) {
            if ($this->command) {
                $this->command->error('No hay usuarios. Ejecuta: php artisan db:seed --class=AdminUserSeeder');
            }

            return null;
        }

        $contentFile = database_path("data/{$slug}-content.php");
        if (! is_file($contentFile)) {
            if ($this->command) {
                $this->command->error("No existe {$contentFile}");
            }

            return null;
        }

        $metaFile = database_path("data/{$slug}-meta.php");
        $meta = is_file($metaFile) ? require $metaFile : [];
        $meta = array_merge($defaults, $meta);

        $content = require $contentFile;

        $translationsFile = database_path("data/{$slug}-translations.php");
        $translations = is_file($translationsFile) ? require $translationsFile : null;

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => $slug],
            [
                'title' => $meta['title'],
                'meta_title' => $meta['meta_title'] ?? $meta['title'],
                'meta_description' => $meta['meta_description'] ?? null,
                'meta_keywords' => $meta['meta_keywords'] ?? null,
                'content' => $content,
                'sections' => [],
                'translations' => $translations,
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_at' => null,
            ]
        );

        if ($page->trashed()) {
            $page->restore();
        }

        return $page;
    }
}
