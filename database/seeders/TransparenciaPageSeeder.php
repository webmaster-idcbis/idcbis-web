<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class TransparenciaPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('transparencia', [
            'title' => 'Transparencia | IDCBIS',
            'meta_title' => 'Transparencia — IDCBIS',
            'meta_description' => 'Portal de transparencia del IDCBIS.',
            'meta_keywords' => 'IDCBIS, transparencia, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /transparencia');
        }
    }
}
