<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class BancoDeSangrePageSeeder extends Seeder
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

        $content = require database_path('data/banco-de-sangre-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'banco-de-sangre'],
            [
                'title' => 'Banco Distrital de Sangre | IDCBIS',
                'meta_description' => 'Donación de sangre, jornadas empresariales, componentes sanguíneos y servicios especializados del Banco Distrital de Sangre del IDCBIS.',
                'meta_title' => 'Banco de Sangre IDCBIS — Donar salva vidas',
                'meta_keywords' => 'banco de sangre, donación, IDCBIS, Bogotá, componentes sanguíneos, jornadas',
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
            $this->command->info('Página creada/actualizada: /banco-de-sangre');
        }
    }
}
