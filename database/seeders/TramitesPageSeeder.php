<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class TramitesPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('tramites', [
            'title' => 'Trámites | IDCBIS',
            'meta_title' => 'Trámites — IDCBIS',
            'meta_description' => 'Información sobre trámites del IDCBIS.',
            'meta_keywords' => 'IDCBIS, trámites, transparencia',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /tramites');
        }
    }
}
