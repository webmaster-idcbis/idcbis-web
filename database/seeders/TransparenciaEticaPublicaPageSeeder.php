<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class TransparenciaEticaPublicaPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('programa-transparencia-etica-publica', [
            'title' => 'Programa de Transparencia y Ética Pública | IDCBIS',
            'meta_title' => 'Programa de Transparencia y Ética Pública — IDCBIS',
            'meta_description' => 'Documentos del Programa de Transparencia y Ética Pública del IDCBIS, organizados por vigencia.',
            'meta_keywords' => 'IDCBIS, transparencia, ética pública, información pública, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /programa-transparencia-etica-publica');
        }
    }
}
