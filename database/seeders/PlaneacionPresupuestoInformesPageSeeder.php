<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class PlaneacionPresupuestoInformesPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('planeacion-presupuesto-e-informes', [
            'title' => 'Planeación, presupuesto e informes | IDCBIS',
            'meta_title' => 'Planeación, presupuesto e informes — IDCBIS',
            'meta_description' => 'Presupuesto, planes de acción e informes de gestión del IDCBIS.',
            'meta_keywords' => 'IDCBIS, planeación, presupuesto, informes, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /planeacion-presupuesto-e-informes');
        }
    }
}
