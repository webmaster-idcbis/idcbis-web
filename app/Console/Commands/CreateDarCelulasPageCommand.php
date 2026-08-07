<?php

namespace App\Console\Commands;

use Database\Seeders\DarCelulasPageSeeder;
use Illuminate\Console\Command;

class CreateDarCelulasPageCommand extends Command
{
    protected $signature = 'page:create-darcelulas';

    protected $description = 'Crea o actualiza la página /darcelulas';

    public function handle(): int
    {
        $this->call(DarCelulasPageSeeder::class);

        return self::SUCCESS;
    }
}
