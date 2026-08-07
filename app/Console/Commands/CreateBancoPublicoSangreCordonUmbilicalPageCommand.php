<?php

namespace App\Console\Commands;

use Database\Seeders\BancoPublicoSangreCordonUmbilicalPageSeeder;
use Illuminate\Console\Command;

class CreateBancoPublicoSangreCordonUmbilicalPageCommand extends Command
{
    protected $signature = 'page:create-banco-publico-sangre-cordon-umbilical';

    protected $description = 'Crea o actualiza la página /banco-publico-sangre-cordon-umbilical';

    public function handle(): int
    {
        $this->call(BancoPublicoSangreCordonUmbilicalPageSeeder::class);

        return self::SUCCESS;
    }
}
