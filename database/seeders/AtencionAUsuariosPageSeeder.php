<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class AtencionAUsuariosPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('atencion-a-usuarios', [
            'title' => 'Atención a Usuarios | IDCBIS',
            'meta_title' => 'Atención y servicio al ciudadano — IDCBIS',
            'meta_description' => 'Canales de atención al ciudadano del IDCBIS: peticiones, horarios, sede y correos institucionales.',
            'meta_keywords' => 'IDCBIS, atención a usuarios, servicio al ciudadano, PQRS, Bogotá Te Escucha',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /atencion-a-usuarios');
        }
    }
}
