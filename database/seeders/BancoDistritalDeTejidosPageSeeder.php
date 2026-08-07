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
            'meta_title' => 'Banco Distrital de Tejidos IDCBIS — Donación y trasplante',
            'meta_description' => 'Banco de tejidos IDCBIS: referente latinoamericano en rescate, procesamiento y distribución. Dermis acelular, córnea, piel y membrana amniótica.',
            'meta_keywords' => 'banco de tejidos, dermis acelular, córnea, donación de tejidos, IDCBIS, Bogotá, INVIMA',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-distrital-de-tejidos');
        }
    }
}
