<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class DarCelulasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('darcelulas', [
            'title' => 'DarCélulas | IDCBIS',
            'meta_title' => 'DarCélulas IDCBIS — Registro Nacional de Donantes de CPH',
            'meta_description' => 'DarCélulas: primer y único registro nacional de donantes de células formadoras de la sangre en Colombia. Inscríbete gratis y ayuda a salvar una vida.',
            'meta_keywords' => 'DarCélulas, donación de médula ósea, células progenitoras hematopoyéticas, CPH, registro de donantes, IDCBIS, Bogotá, tipificación HLA',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /darcelulas');
        }
    }
}
