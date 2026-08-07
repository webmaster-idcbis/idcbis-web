<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class UnidadDeTerapiasAvanzadasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('unidad-de-terapias-avanzadas', [
            'title' => 'Unidad de Terapias Avanzadas | IDCBIS',
            'meta_title' => 'Unidad de Terapias Avanzadas (UTA) | IDCBIS',
            'meta_description' => 'Investigación y desarrollo en terapia celular, génica e ingeniería tisular. Sala blanca BPM, OmiMed NGS y ensayos clínicos en el IDCBIS.',
            'meta_keywords' => 'terapias avanzadas, UTA, terapia celular, ingeniería tisular, CAR-T, NGS, OmiMed, IDCBIS, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /unidad-de-terapias-avanzadas');
        }
    }
}
