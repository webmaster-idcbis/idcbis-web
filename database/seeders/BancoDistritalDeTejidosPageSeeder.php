<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class BancoDistritalDeTejidosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('banco-distrital-de-tejidos', [
            'title' => 'Banco Distrital de Tejidos | IDCBIS',
            'meta_title' => 'Banco Distrital de Tejidos IDCBIS — donación y trasplante',
            'meta_description' => 'Primer banco multitejidos de Colombia. Suministro de tejidos oculares, piel, dermis y osteomusculares con calidad, seguridad y trazabilidad.',
            'meta_keywords' => 'banco de tejidos, donación de tejidos, córnea, dermis acelular, membrana amniótica, osteomuscular, IDCBIS, INVIMA, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-distrital-de-tejidos');
        }
    }
}
