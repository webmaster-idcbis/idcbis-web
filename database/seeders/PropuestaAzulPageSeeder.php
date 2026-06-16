<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PropuestaAzulPageSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@idcbis.gov.co')->first()
            ?? User::query()->first();

        if (! $user) {
            if ($this->command) {
                $this->command->error('No hay usuarios. Ejecuta primero: php artisan db:seed --class=AdminUserSeeder');
            }

            return;
        }

        $content = require database_path('data/propuesta-azul-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'inicio'],
            [
                'title' => 'IDCBIS | Ciencia que te conecta con la vida',
                'meta_description' => 'Donar sangre, tejidos o cordón umbilical. Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
                'meta_title' => 'IDCBIS | Ciencia que te conecta con la vida',
                'meta_keywords' => 'IDCBIS, donación, sangre, tejidos, cordón umbilical, Bogotá',
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
            $this->command->info('Página creada/actualizada: slug "inicio" → URL /inicio');
            $this->command->info('Coloca las imágenes en public/img/ (ver public/img/IMAGENES.txt)');
        }
    }
}
