<?php

namespace App\Console\Commands;

use Database\Seeders\RendicionDeCuentasPageSeeder;
use Illuminate\Console\Command;

class CreateRendicionDeCuentasPageCommand extends Command
{
    protected $signature = 'page:create-rendicion-de-cuentas';

    protected $description = 'Crea o actualiza la página /rendicion-de-cuentas';

    public function handle(): int
    {
        $this->call(RendicionDeCuentasPageSeeder::class);

        return self::SUCCESS;
    }
}
