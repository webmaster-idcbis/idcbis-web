<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class NormativaPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('normativa', [
            'title' => 'Normativa | IDCBIS',
            'meta_title' => 'Normativa — IDCBIS',
            'meta_description' => 'Normograma y sistemas de consulta normativa del IDCBIS.',
            'meta_keywords' => 'IDCBIS, normativa, normograma, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /normativa');
        }
    }
}
