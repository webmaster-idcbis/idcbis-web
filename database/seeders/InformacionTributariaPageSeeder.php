<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InformacionTributariaPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('informacion-tributaria-entidades-territoriales', [
            'title' => 'Información tributaria | IDCBIS',
            'meta_title' => 'Información tributaria — IDCBIS',
            'meta_description' => 'Información tributaria en entidades territoriales locales.',
            'meta_keywords' => 'IDCBIS, información tributaria, ICA, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /informacion-tributaria-entidades-territoriales');
        }
    }
}
