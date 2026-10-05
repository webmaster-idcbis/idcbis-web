<?php

namespace App\Console\Commands;

use Database\Seeders\InvestigacionCelulasProgenitorasPageSeeder;
use Database\Seeders\InvestigacionMedicinaTransfusionalPageSeeder;
use Database\Seeders\InvestigacionNeurocienciasPageSeeder;
use Database\Seeders\InvestigacionTerapiasAvanzadasPageSeeder;
use Database\Seeders\InvestigacionPageSeeder;
use Illuminate\Console\Command;

class CreateInvestigacionPagesCommand extends Command
{
    protected $signature = 'page:create-investigacion';

    protected $description = 'Crea o actualiza /investigacion y sus subpáginas de líneas';

    public function handle(): int
    {
        foreach ([
            InvestigacionPageSeeder::class,
            InvestigacionCelulasProgenitorasPageSeeder::class,
            InvestigacionMedicinaTransfusionalPageSeeder::class,
            InvestigacionTerapiasAvanzadasPageSeeder::class,
            InvestigacionNeurocienciasPageSeeder::class,
        ] as $seeder) {
            $this->call($seeder);
        }

        $this->info('Páginas de investigación creadas/actualizadas.');

        return self::SUCCESS;
    }
}
