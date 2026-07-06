<?php

namespace App\Console\Commands;

use Database\Seeders\ContratacionBienesServiciosPageSeeder;
use Illuminate\Console\Command;

class CreateContratacionBienesServiciosPageCommand extends Command
{
    protected $signature = 'page:create-contratacion-bienes-servicios';

    protected $description = 'Crea o actualiza la página /contratacion-bienes-servicios';

    public function handle(): int
    {
        $this->call(ContratacionBienesServiciosPageSeeder::class);

        return self::SUCCESS;
    }
}
