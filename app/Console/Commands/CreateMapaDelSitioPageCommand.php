<?php

namespace App\Console\Commands;

use Database\Seeders\MapaDelSitioPageSeeder;
use Illuminate\Console\Command;

class CreateMapaDelSitioPageCommand extends Command
{
    protected $signature = 'page:create-mapa-del-sitio';

    protected $description = 'Crea o actualiza la página CMS /mapa-del-sitio';

    public function handle(): int
    {
        $this->call(MapaDelSitioPageSeeder::class);

        return self::SUCCESS;
    }
}
