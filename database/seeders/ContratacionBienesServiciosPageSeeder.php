<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class ContratacionBienesServiciosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('contratacion-bienes-servicios', [
            'title' => 'Contratación bienes y servicios | IDCBIS',
            'meta_title' => 'Contratación bienes y servicios — IDCBIS',
            'meta_description' => 'Manual de contratación e informes mensuales de contratos y modificaciones contractuales del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_keywords' => 'IDCBIS, contratación, bienes y servicios, transparencia, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /contratacion-bienes-servicios');
        }
    }
}
