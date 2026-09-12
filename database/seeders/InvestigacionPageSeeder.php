<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('investigacion', [
            'title' => 'Investigación IDCBIS',
            'meta_title' => 'Investigación IDCBIS — GIMTTyC',
            'meta_description' => 'Grupo de Investigación en Medicina Transfusional, Tisular y Celular. Líneas, proyectos y reconocimientos MinCiencias.',
            'meta_keywords' => 'IDCBIS, investigación, GIMTTyC, MinCiencias, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /investigacion');
        }
    }
}
