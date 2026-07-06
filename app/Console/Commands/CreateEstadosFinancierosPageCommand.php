<?php

namespace App\Console\Commands;

use Database\Seeders\EstadosFinancierosPageSeeder;
use Illuminate\Console\Command;

class CreateEstadosFinancierosPageCommand extends Command
{
    protected $signature = 'page:create-estados-financieros';

    protected $description = 'Crea o actualiza la página /estados-financieros';

    public function handle(): int
    {
        $this->call(EstadosFinancierosPageSeeder::class);

        return self::SUCCESS;
    }
}
