<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionCelulasProgenitorasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('investigacion-celulas-progenitoras-hematopoyeticas', [
            'title' => 'Investigación en Células Progenitoras Hematopoyéticas | IDCBIS',
            'meta_title' => 'Investigación CPH y sangre de cordón | IDCBIS',
            'meta_description' => 'Línea de investigación del BSCU: banqueo, trasplante de CPH y Registro Nacional de Donantes.',
            'meta_keywords' => 'CPH, sangre de cordón, BSCU, DarCélulas, IDCBIS',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /investigacion-celulas-progenitoras-hematopoyeticas');
        }
    }
}
