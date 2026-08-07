<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class BancoDeSangrePageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('banco-de-sangre', [
            'title' => 'Banco Distrital de Sangre | IDCBIS',
            'meta_title' => 'Banco de Sangre IDCBIS — Donar salva vidas',
            'meta_description' => 'Donación de sangre, jornadas empresariales, componentes sanguíneos y servicios especializados del Banco Distrital de Sangre del IDCBIS.',
            'meta_keywords' => 'banco de sangre, donación, IDCBIS, Bogotá, componentes sanguíneos, jornadas',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-de-sangre');
        }
    }
}
