<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionTerapiasAvanzadasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $pages = [
            'investigacion-terapias-avanzadas' => [
                'title' => 'Unidad de Terapias Avanzadas | IDCBIS',
                'meta_title' => 'Unidad de Terapias Avanzadas | IDCBIS',
                'meta_description' => 'Unidad de Terapias Avanzadas del IDCBIS: neurociencias, ingeniería tisular, innovación y producción, e inmunoterapia.',
                'meta_keywords' => 'IDCBIS, unidad de terapias avanzadas, neurociencias, ingeniería tisular, inmunoterapia',
            ],
            'investigacion-neurociencias' => [
                'title' => 'Neurociencias | IDCBIS',
                'meta_title' => 'Neurociencias | IDCBIS',
                'meta_description' => 'Neurociencias, línea de la Unidad de Terapias Avanzadas del IDCBIS.',
                'meta_keywords' => 'IDCBIS, neurociencias, unidad de terapias avanzadas',
            ],
            'investigacion-ingenieria-tisular' => [
                'title' => 'Ingeniería tisular | IDCBIS',
                'meta_title' => 'Ingeniería tisular | IDCBIS',
                'meta_description' => 'Ingeniería tisular, línea de la Unidad de Terapias Avanzadas del IDCBIS.',
                'meta_keywords' => 'IDCBIS, ingeniería tisular, unidad de terapias avanzadas',
            ],
            'investigacion-innovacion-produccion' => [
                'title' => 'Innovación y producción | IDCBIS',
                'meta_title' => 'Innovación y producción | IDCBIS',
                'meta_description' => 'Innovación y producción, línea de la Unidad de Terapias Avanzadas del IDCBIS.',
                'meta_keywords' => 'IDCBIS, innovación, producción, unidad de terapias avanzadas',
            ],
            'investigacion-inmunoterapia' => [
                'title' => 'Inmunoterapia | IDCBIS',
                'meta_title' => 'Inmunoterapia | IDCBIS',
                'meta_description' => 'Inmunoterapia, línea de la Unidad de Terapias Avanzadas del IDCBIS.',
                'meta_keywords' => 'IDCBIS, inmunoterapia, unidad de terapias avanzadas',
            ],
        ];

        foreach ($pages as $slug => $defaults) {
            $page = $this->seedPageFromDataFiles($slug, $defaults);

            if ($page && $this->command) {
                $this->command->info("Página creada/actualizada: /{$slug}");
            }
        }
    }
}
