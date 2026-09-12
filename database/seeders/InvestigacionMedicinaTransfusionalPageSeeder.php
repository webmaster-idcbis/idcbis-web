<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionMedicinaTransfusionalPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('investigacion-medicina-transfusional', [
            'title' => 'Medicina transfusional e inmunohematología avanzada | IDCBIS',
            'meta_title' => 'Inmunohematología y fenotipos raros | IDCBIS',
            'meta_description' => 'Laboratorio de Inmunohematología Molecular y Registro de Donantes Únicos IDCBIS.',
            'meta_keywords' => 'fenotipos raros, inmunohematología, donantes únicos, IDCBIS',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /investigacion-medicina-transfusional');
        }
    }
}
