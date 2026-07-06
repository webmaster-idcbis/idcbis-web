<?php

namespace App\Console\Commands;

use Database\Seeders\TransparenciaEticaPublicaPageSeeder;
use Illuminate\Console\Command;

class CreateTransparenciaEticaPublicaPageCommand extends Command
{
    protected $signature = 'page:create-transparencia-etica-publica';

    protected $description = 'Crea o actualiza la página /programa-transparencia-etica-publica';

    public function handle(): int
    {
        $this->call(TransparenciaEticaPublicaPageSeeder::class);

        return self::SUCCESS;
    }
}
