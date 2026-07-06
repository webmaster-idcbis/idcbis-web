<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class EjecucionPresupuestalPageSeeder extends Seeder
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

        $content = require database_path('data/ejecucion-presupuestal-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'ejecucion-presupuestal'],
            [
                'title' => 'Ejecución presupuestal | IDCBIS',
                'meta_title' => 'Ejecución presupuestal — IDCBIS',
                'meta_description' => 'Informes mensuales de ejecución presupuestal del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud, organizados por vigencia.',
                'meta_keywords' => 'IDCBIS, ejecución presupuestal, transparencia, información pública, Bogotá',
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
            $this->command->info('Página creada/actualizada: /ejecucion-presupuestal');
            $this->command->comment('Agrega URLs de PDF en database/data/ejecucion-presupuestal-page.php');
        }
    }
}
