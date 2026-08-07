<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InformacionGruposDeInteresPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('informacion-grupos-de-interes', [
            'title' => 'Información específica para grupos de interés | IDCBIS',
            'meta_title' => 'Grupos de interés — IDCBIS',
            'meta_description' => 'Información del IDCBIS para niños, niñas, adolescentes y mujeres.',
            'meta_keywords' => 'IDCBIS, grupos de interés, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /informacion-grupos-de-interes');
        }
    }
}
