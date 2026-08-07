<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class QuienesSomosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('quienes-somos', [
            'title' => 'Quiénes Somos | IDCBIS',
            'meta_title' => 'Quiénes Somos — Instituto IDCBIS',
            'meta_description' => 'Conoce la misión, visión, equipo directivo y funciones del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud de Bogotá.',
            'meta_keywords' => 'IDCBIS, quiénes somos, misión, visión, instituto, Bogotá, investigación, banco de sangre',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /quienes-somos');
        }
    }
}
