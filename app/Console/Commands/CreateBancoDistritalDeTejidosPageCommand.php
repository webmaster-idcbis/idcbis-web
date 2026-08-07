<?php

namespace App\Console\Commands;

use Database\Seeders\BancoDistritalDeTejidosPageSeeder;
use Illuminate\Console\Command;

class CreateBancoDistritalDeTejidosPageCommand extends Command
{
    protected $signature = 'page:create-banco-distrital-de-tejidos';

    protected $description = 'Crea o actualiza la página /banco-distrital-de-tejidos';

    public function handle(): int
    {
        $this->call(BancoDistritalDeTejidosPageSeeder::class);

        return self::SUCCESS;
    }
}
