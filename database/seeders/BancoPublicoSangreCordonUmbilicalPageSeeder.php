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
            'title' => 'Banco de Sangre de Cordón Umbilical | IDCBIS',
            'meta_title' => 'Banco de sangre de cordón umbilical | IDCBIS',
            'meta_description' => 'Investigación y banco público de sangre de cordón umbilical. Trasplante, registro y evidencia del IDCBIS en Colombia.',
            'meta_keywords' => 'sangre de cordón umbilical, BSCU, trasplante, células progenitoras, registro, IDCBIS, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /banco-publico-sangre-cordon-umbilical');
        }
    }
}
