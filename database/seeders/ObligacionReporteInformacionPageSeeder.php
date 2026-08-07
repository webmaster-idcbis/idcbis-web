<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class ObligacionReporteInformacionPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('obligacion-reporte-informacion', [
            'title' => 'Obligación de reporte de información | IDCBIS',
            'meta_title' => 'Obligación de reporte — IDCBIS',
            'meta_description' => 'Instancias de coordinación, decisiones de gobierno, bases de datos SIC y RTE del IDCBIS.',
            'meta_keywords' => 'IDCBIS, obligación de reporte, RTE, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /obligacion-reporte-informacion');
        }
    }
}
