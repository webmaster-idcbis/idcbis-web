<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class ParticipaPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('participa', [
            'title' => 'Participa | IDCBIS',
            'meta_title' => 'Participa — IDCBIS',
            'meta_description' => 'Espacios y mecanismos de participación ciudadana del IDCBIS.',
            'meta_keywords' => 'IDCBIS, participa, participación ciudadana, gobierno abierto, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /participa');
        }
    }
}
