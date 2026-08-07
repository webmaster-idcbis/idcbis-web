<?php

namespace App\Console\Commands;

use Database\Seeders\UnidadDeTerapiasAvanzadasPageSeeder;
use Illuminate\Console\Command;

class CreateUnidadDeTerapiasAvanzadasPageCommand extends Command
{
    protected $signature = 'page:create-unidad-de-terapias-avanzadas';

    protected $description = 'Crea o actualiza la página /unidad-de-terapias-avanzadas';

    public function handle(): int
    {
        $this->call(UnidadDeTerapiasAvanzadasPageSeeder::class);

        return self::SUCCESS;
    }
}
