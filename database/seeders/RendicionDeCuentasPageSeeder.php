<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class RendicionDeCuentasPageSeeder extends Seeder
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

        $content = require database_path('data/rendicion-de-cuentas-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'rendicion-de-cuentas'],
            [
                'title' => 'Rendición de Cuentas | IDCBIS',
                'meta_title' => 'Rendición de Cuentas — IDCBIS',
                'meta_description' => 'Informes, presentaciones y documentos de rendición de cuentas del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
                'meta_keywords' => 'IDCBIS, rendición de cuentas, transparencia, control social, información pública, Bogotá',
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
            $this->command->info('Página creada/actualizada: /rendicion-de-cuentas');
            $this->command->comment('Agrega URLs de PDF y video en database/data/rendicion-de-cuentas-page.php');
        }
    }
}
