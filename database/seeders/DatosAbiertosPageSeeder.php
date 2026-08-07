<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class DatosAbiertosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('datos-abiertos', [
            'title' => 'Datos Abiertos | IDCBIS',
            'meta_title' => 'Datos Abiertos — IDCBIS',
            'meta_description' => 'Datos abiertos e instrumentos de gestión de la información del IDCBIS.',
            'meta_keywords' => 'IDCBIS, datos abiertos, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /datos-abiertos');
        }
    }
}
