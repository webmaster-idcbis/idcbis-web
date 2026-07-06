<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuienesSomosPageSeeder extends Seeder
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

        $content = require database_path('data/quienes-somos-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'quienes-somos'],
            [
                'title' => 'Quiénes Somos | IDCBIS',
                'meta_title' => 'Quiénes Somos — Instituto IDCBIS',
                'meta_description' => 'Conoce la misión, visión, equipo directivo y funciones del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud de Bogotá.',
                'meta_keywords' => 'IDCBIS, quiénes somos, misión, visión, instituto, Bogotá, investigación, banco de sangre',
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
            $this->command->info('Página creada/actualizada: /quienes-somos');
            $this->command->comment('Edita el contenido desde Admin → Páginas → Quiénes Somos');
        }
    }
}
