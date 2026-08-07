<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class RendicionDeCuentasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('rendicion-de-cuentas', [
            'title' => 'Rendición de Cuentas | IDCBIS',
            'meta_title' => 'Rendición de Cuentas — IDCBIS',
            'meta_description' => 'Informes, presentaciones y documentos de rendición de cuentas del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_keywords' => 'IDCBIS, rendición de cuentas, transparencia, control social, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /rendicion-de-cuentas');
        }
    }
}
