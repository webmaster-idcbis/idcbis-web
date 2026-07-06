<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class TransparenciaEticaPublicaPageSeeder extends Seeder
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

        $content = require database_path('data/programa-transparencia-etica-publica-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'programa-transparencia-etica-publica'],
            [
                'title' => 'Programa de Transparencia y Ética Pública | IDCBIS',
                'meta_title' => 'Programa de Transparencia y Ética Pública — IDCBIS',
                'meta_description' => 'Documentos, informes y seguimientos del Programa de Transparencia y Ética Pública del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
                'meta_keywords' => 'IDCBIS, transparencia, ética pública, documentos, informes, seguimiento, Bogotá',
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
            $this->command->info('Página creada/actualizada: /programa-transparencia-etica-publica');
            $this->command->comment('Agrega URLs de PDF en database/data/programa-transparencia-etica-publica-page.php');
        }
    }
}
