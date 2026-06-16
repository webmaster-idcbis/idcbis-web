<?php

namespace App\Console\Commands;

use Database\Seeders\PropuestaAzulPageSeeder;
use Illuminate\Console\Command;

class CreatePropuestaAzulPageCommand extends Command
{
    protected $signature = 'page:create-propuesta-azul';

    protected $description = 'Crea o actualiza la página publicada /inicio (Propuesta Azul IDCBIS)';

    public function handle(): int
    {
        $this->call(PropuestaAzulPageSeeder::class);

        return self::SUCCESS;
    }
}
