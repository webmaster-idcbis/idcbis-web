<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class SitemapPagesSeeder extends Seeder
{
    /**
     * Crea páginas placeholder publicadas para las rutas del mapa del sitio.
     * El contenido se irá reemplazando al editar cada página en el CMS.
     */
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@idcbis.gov.co')->first()
            ?? User::query()->first();

        if (! $user) {
            if ($this->command) {
                $this->command->error('No hay usuarios. Ejecuta: php artisan db:seed --class=AdminUserSeeder');
            }

            return;
        }

        $pages = require database_path('data/sitemap-pages.php');
        $created = 0;
        $skipped = 0;

        foreach ($pages as $pageData) {
            $existing = Page::withTrashed()->where('slug', $pageData['slug'])->first();

            if ($existing && ! $existing->trashed() && ($pageData['skip_if_exists'] ?? true)) {
                $skipped++;
                continue;
            }

            $page = Page::withTrashed()->updateOrCreate(
                ['slug' => $pageData['slug']],
                [
                    'title' => $pageData['title'],
                    'meta_description' => $pageData['meta_description'] ?? null,
                    'meta_title' => $pageData['meta_title'] ?? $pageData['title'],
                    'content' => $this->placeholderContent($pageData['title']),
                    'sections' => [],
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

            $created++;
        }

        if ($this->command) {
            $this->command->info("Mapa del sitio: {$created} páginas creadas/actualizadas, {$skipped} omitidas (ya existían).");
        }
    }

    private function placeholderContent(string $title): array
    {
        return [
            [
                'id' => 'placeholder_heading',
                'type' => 'heading',
                'content' => $title,
                'level' => 'h1',
                'variant' => 'page',
                'textAlign' => 'center',
                'margin' => '0 0 16px',
            ],
            [
                'id' => 'placeholder_text',
                'type' => 'text',
                'content' => 'Esta sección está en construcción. Pronto encontrarás aquí la información completa.',
                'textAlign' => 'center',
                'color' => '#64748b',
                'fontSize' => '18px',
                'margin' => '0 auto 24px',
                'maxWidth' => '640px',
            ],
            [
                'id' => 'placeholder_actions',
                'type' => 'container',
                'display' => 'flex',
                'flexDirection' => 'row',
                'justifyContent' => 'center',
                'gap' => '16px',
                'flexWrap' => 'wrap',
                'padding' => '24px',
                'backgroundColor' => 'transparent',
                'children' => [
                    [
                        'id' => 'placeholder_btn_home',
                        'type' => 'button',
                        'content' => 'Volver al inicio',
                        'href' => '/',
                        'backgroundColor' => '#005674',
                        'color' => '#ffffff',
                        'padding' => '12px 24px',
                        'borderRadius' => '8px',
                    ],
                    [
                        'id' => 'placeholder_btn_sitemap',
                        'type' => 'button',
                        'content' => 'Mapa del sitio',
                        'href' => '/mapa-del-sitio',
                        'backgroundColor' => '#ffffff',
                        'color' => '#005674',
                        'border' => '2px solid #005674',
                        'padding' => '12px 24px',
                        'borderRadius' => '8px',
                    ],
                ],
            ],
        ];
    }
}
