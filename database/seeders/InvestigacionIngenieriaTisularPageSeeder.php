<?php

namespace Database\Seeders;

use Database\Seeders\Concerns\SeedsCmsPageFromDataFiles;
use Illuminate\Database\Seeder;

class InvestigacionIngenieriaTisularPageSeeder extends Seeder
{
    use SeedsCmsPageFromDataFiles;

    public function run(): void
    {
        $pages = [
            'investigacion-ingenieria-tisular' => [
                'title' => 'Ingeniería tisular | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-hueso' => [
                'title' => 'Hueso | Ingeniería de tejidos | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-piel' => [
                'title' => 'Piel | Ingeniería de tejidos | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-cartilago' => [
                'title' => 'Cartílago | Ingeniería de tejidos | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-otras' => [
                'title' => 'Otras líneas | Ingeniería de tejidos | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-3d-quyne' => [
                'title' => '3D QUYNE | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-matriacel' => [
                'title' => 'MatriAcel | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-pcem-tgpiel' => [
                'title' => 'PCEM-TGPiel | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-fibroglic' => [
                'title' => 'Fibroglic | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-hyalovite' => [
                'title' => 'Hyalovite | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-dispositivos-osteocondrales' => [
                'title' => 'Dispositivos osteocondrales | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-pcl-pva' => [
                'title' => 'PCL con hidrogel de PVA/LP | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-vesiculas-extracelulares' => [
                'title' => 'Vesículas extracelulares | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-progenitores-hematopoyeticos' => [
                'title' => 'Progenitores hematopoyéticos | IDCBIS',
            ],
            'investigacion-ingenieria-tisular-tejido-vascular' => [
                'title' => 'Tejido vascular | IDCBIS',
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
