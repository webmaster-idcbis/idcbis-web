<?php

namespace App\Console\Commands;

use Database\Seeders\EjecucionPresupuestalPageSeeder;
use Illuminate\Console\Command;

class CreateEjecucionPresupuestalPageCommand extends Command
{
    protected $signature = 'page:create-ejecucion-presupuestal';

    protected $description = 'Crea o actualiza la página /ejecucion-presupuestal';

    public function handle(): int
    {
        $this->call(EjecucionPresupuestalPageSeeder::class);

        return self::SUCCESS;
    }
}
