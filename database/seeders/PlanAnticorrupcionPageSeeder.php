<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class PlanAnticorrupcionPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('plan-anticorrupcion', [
            'title' => 'Plan anticorrupción | IDCBIS',
            'meta_title' => 'Plan anticorrupción — IDCBIS',
            'meta_description' => 'Plan Anticorrupción y de Atención al Ciudadano (PAAC) del IDCBIS. Consulta planes y seguimientos por vigencia.',
            'meta_keywords' => 'IDCBIS, plan anticorrupción, PAAC, transparencia, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /plan-anticorrupcion');
        }
    }
}
