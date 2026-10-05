<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionNeurocienciasPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $pages = [
            'investigacion-neurociencias' => [
                'title' => 'Neurociencias | IDCBIS',
                'meta_title' => 'Neurociencias | IDCBIS',
                'meta_description' => 'El grupo de Neurociencias del IDCBIS estudia el sistema nervioso y la neuroregeneración en la Unidad de Terapias Avanzadas.',
                'meta_keywords' => 'IDCBIS, neurociencias, unidad de terapias avanzadas',
            ],
            'investigacion-neurociencias-trauma-raquimedular' => [
                'title' => 'Trauma raquimedular | IDCBIS',
            ],
            'investigacion-neurociencias-cannabis-terapeutico' => [
                'title' => 'Cannabis terapéutico | IDCBIS',
            ],
            'investigacion-neurociencias-biomarcadores-alzheimer' => [
                'title' => 'Biomarcadores en Alzheimer | IDCBIS',
            ],
            'investigacion-neurociencias-progenitores-neurales' => [
                'title' => 'Progenitores neurales | IDCBIS',
            ],
            'investigacion-neurociencias-bioensambles-parkinson' => [
                'title' => 'Bioensambles en Parkinson | IDCBIS',
            ],
            'investigacion-neurociencias-isquemia-cerebral' => [
                'title' => 'Isquemia cerebral | IDCBIS',
            ],
            'investigacion-neurociencias-injerto-nervioso-acelular' => [
                'title' => 'Injerto nervioso acelular | IDCBIS',
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
