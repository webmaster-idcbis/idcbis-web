<?php

namespace App\Console\Commands;

use Database\Seeders\QuienesSomosPageSeeder;
use Illuminate\Console\Command;

class CreateQuienesSomosPageCommand extends Command
{
    protected $signature = 'page:create-quienes-somos';

    protected $description = 'Crea o actualiza la página /quienes-somos';

    public function handle(): int
    {
        $this->call(QuienesSomosPageSeeder::class);

        return self::SUCCESS;
    }
}
