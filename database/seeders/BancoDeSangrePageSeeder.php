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
            'meta_title' => 'Dona sangre, salva vidas | Banco de Sangre IDCBIS',
            'meta_description' => 'Dona sangre en el IDCBIS: 15 minutos, 450 ml y hasta 3 vidas salvadas. Agenda tu donación en Bogotá.',
            'meta_keywords' => 'banco de sangre, donación, IDCBIS, Bogotá, agendar donación, requisitos donante',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-de-sangre');
        }
    }
}
