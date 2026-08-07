<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class ContratacionPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('contratacion', [
            'title' => 'Contratación | IDCBIS',
            'meta_title' => 'Contratación — IDCBIS',
            'meta_description' => 'Planes de necesidades, SECOP e información contractual del IDCBIS.',
            'meta_keywords' => 'IDCBIS, contratación, SECOP, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /contratacion');
        }
    }
}
