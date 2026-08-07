<?php

namespace App\Console\Commands;

use Database\Seeders\AtencionAUsuariosPageSeeder;
use Illuminate\Console\Command;

class CreateAtencionAUsuariosPageCommand extends Command
{
    protected $signature = 'page:create-atencion-a-usuarios';

    protected $description = 'Crea o actualiza la página /atencion-a-usuarios';

    public function handle(): int
    {
        $this->call(AtencionAUsuariosPageSeeder::class);

        return self::SUCCESS;
    }
}
