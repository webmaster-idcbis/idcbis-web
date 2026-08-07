<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class ContactoPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('contacto', [
            'title' => 'Contáctenos | IDCBIS',
            'meta_title' => 'Contáctenos — IDCBIS',
            'meta_description' => 'Comunícate con el Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_keywords' => 'IDCBIS, contacto, sede, teléfono, correo, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /contacto');
        }
    }
}
