<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class GestionActivosFijosAlmacenPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('gestion-de-activos-fijos-y-almacen', [
            'title' => 'Gestión de activos fijos y almacén | IDCBIS',
            'meta_title' => 'Gestión de activos fijos — IDCBIS',
            'meta_description' => 'Actas de comité de inventarios y baja de bienes del IDCBIS.',
            'meta_keywords' => 'IDCBIS, activos fijos, almacén, inventarios, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /gestion-de-activos-fijos-y-almacen');
        }
    }
}
