<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class EjecucionPresupuestalPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('ejecucion-presupuestal', [
            'title' => 'Ejecución presupuestal | IDCBIS',
            'meta_title' => 'Ejecución presupuestal — IDCBIS',
            'meta_description' => 'Informes mensuales de ejecución presupuestal del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud, organizados por vigencia.',
            'meta_keywords' => 'IDCBIS, ejecución presupuestal, transparencia, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /ejecucion-presupuestal');
        }
    }
}
