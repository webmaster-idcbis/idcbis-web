<?php

namespace App\Console\Commands;

use Database\Seeders\ContratacionPageSeeder;
use Database\Seeders\DatosAbiertosPageSeeder;
use Database\Seeders\GestionActivosFijosAlmacenPageSeeder;
use Database\Seeders\InformacionDeLaEntidadPageSeeder;
use Database\Seeders\InformacionGruposDeInteresPageSeeder;
use Database\Seeders\InformacionTributariaPageSeeder;
use Database\Seeders\NormativaPageSeeder;
use Database\Seeders\ObligacionReporteInformacionPageSeeder;
use Database\Seeders\PlaneacionPresupuestoInformesPageSeeder;
use Database\Seeders\TramitesPageSeeder;
use Database\Seeders\TransparenciaPageSeeder;
use Illuminate\Console\Command;

class CreateTransparenciaPagesCommand extends Command
{
    protected $signature = 'page:create-transparencia';

    protected $description = 'Crea o actualiza la página /transparencia y sus subpáginas';

    public function handle(): int
    {
        $seeders = [
            TransparenciaPageSeeder::class,
            InformacionDeLaEntidadPageSeeder::class,
            NormativaPageSeeder::class,
            ContratacionPageSeeder::class,
            PlaneacionPresupuestoInformesPageSeeder::class,
            TramitesPageSeeder::class,
            DatosAbiertosPageSeeder::class,
            InformacionGruposDeInteresPageSeeder::class,
            ObligacionReporteInformacionPageSeeder::class,
            InformacionTributariaPageSeeder::class,
            GestionActivosFijosAlmacenPageSeeder::class,
        ];

        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }

        $this->info('Páginas de transparencia creadas/actualizadas.');

        return self::SUCCESS;
    }
}
