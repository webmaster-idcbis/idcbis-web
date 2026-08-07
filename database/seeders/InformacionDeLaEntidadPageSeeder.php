<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InformacionDeLaEntidadPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('informacion-de-la-entidad', [
            'title' => 'Información de la entidad | IDCBIS',
            'meta_title' => 'Información de la entidad — IDCBIS',
            'meta_description' => 'Misión, visión, funciones y estructura del IDCBIS.',
            'meta_keywords' => 'IDCBIS, información de la entidad, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /informacion-de-la-entidad');
        }
    }
}
