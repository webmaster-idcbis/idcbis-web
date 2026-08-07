<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class NoticiasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $page = $this->seedPageFromDataFiles('noticias', [
            'title' => 'Noticias | IDCBIS',
            'meta_title' => 'Noticias — IDCBIS',
            'meta_description' => 'Noticias, avances y novedades del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_keywords' => 'IDCBIS, noticias, investigación, sangre, tejidos, donación, Bogotá',
        ]);

        if ($page && $this->command) {
            $this->command->info('Página creada/actualizada: /noticias');
        }

        $this->call(PostsSeeder::class);
    }
}
