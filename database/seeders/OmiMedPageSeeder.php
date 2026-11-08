<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class OmiMedPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('omimed', [
            'title' => 'OmiMed | IDCBIS',
            'meta_title' => 'OmiMed — Ciencias ómicas y medicina personalizada | IDCBIS',
            'meta_description' => 'Laboratorio OmiMed del IDCBIS: secuenciación NGS de ADN y ARN, ciencias ómicas y medicina personalizada en Bogotá.',
            'meta_keywords' => 'OmiMed, NGS, secuenciación, ciencias ómicas, medicina personalizada, genómica, IDCBIS, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /omimed');
        }
    }
}
