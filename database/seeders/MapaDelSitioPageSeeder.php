<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class MapaDelSitioPageSeeder extends Seeder
{
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

        $content = require database_path('data/mapa-del-sitio-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'mapa-del-sitio'],
            [
                'title' => 'Mapa del sitio',
                'meta_title' => 'Mapa del sitio | IDCBIS',
                'meta_description' => 'Índice de todas las secciones y páginas del sitio web del IDCBIS.',
                'meta_keywords' => 'mapa del sitio, IDCBIS, navegación, secciones',
                'content' => $content,
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

        if ($this->command) {
            $this->command->info('Página creada/actualizada: /mapa-del-sitio (visible en Admin → Páginas)');
        }
    }
}
