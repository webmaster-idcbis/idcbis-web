<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class MapaDelSitioPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('mapa-del-sitio', [
            'title' => 'Mapa del sitio | IDCBIS',
            'meta_title' => 'Mapa del sitio — IDCBIS',
            'meta_description' => 'Índice de todas las secciones del sitio web del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_keywords' => 'IDCBIS, mapa del sitio, navegación',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /mapa-del-sitio');
        }
    }
}
