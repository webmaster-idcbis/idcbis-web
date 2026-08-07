<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class EstadosFinancierosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('estados-financieros', [
            'title' => 'Estados Financieros | IDCBIS',
            'meta_title' => 'Estados Financieros — IDCBIS',
            'meta_description' => 'Estados financieros del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud, organizados por período de corte.',
            'meta_keywords' => 'IDCBIS, estados financieros, transparencia, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /estados-financieros');
        }
    }
}
