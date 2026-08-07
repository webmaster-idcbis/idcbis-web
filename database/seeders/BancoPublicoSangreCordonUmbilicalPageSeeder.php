<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class BancoPublicoSangreCordonUmbilicalPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('banco-publico-sangre-cordon-umbilical', [
            'title' => 'Banco Público de Sangre de Cordón Umbilical | IDCBIS',
            'meta_title' => 'Sangre de Cordón Umbilical | IDCBIS',
            'meta_description' => 'Primer banco público de sangre de cordón umbilical de Colombia. Programa Cordial, IDCBISMatch y trasplante de células progenitoras.',
            'meta_keywords' => 'sangre de cordón umbilical, BSCU, donación cordón, trasplante, células madre, IDCBIS, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-publico-sangre-cordon-umbilical');
        }
    }
}
