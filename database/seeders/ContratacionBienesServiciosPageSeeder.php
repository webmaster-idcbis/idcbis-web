<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class ContratacionBienesServiciosPageSeeder extends Seeder
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

        $content = require database_path('data/contratacion-bienes-servicios-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'contratacion-bienes-servicios'],
            [
                'title' => 'Contratación bienes y servicios | IDCBIS',
                'meta_title' => 'Contratación bienes y servicios — IDCBIS',
                'meta_description' => 'Manual de contratación e informes mensuales de contratos y modificaciones contractuales del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
                'meta_keywords' => 'IDCBIS, contratación, bienes y servicios, transparencia, información pública, Bogotá',
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
            $this->command->info('Página creada/actualizada: /contratacion-bienes-servicios');
            $this->command->comment('Agrega URLs de PDF en database/data/contratacion-bienes-servicios-page.php');
        }
    }
}
