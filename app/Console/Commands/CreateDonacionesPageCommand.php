<?php

namespace App\Console\Commands;

use Database\Seeders\DonacionesPageSeeder;
use Illuminate\Console\Command;

class CreateDonacionesPageCommand extends Command
{
    protected $signature = 'page:create-donaciones';

    protected $description = 'Crea o actualiza la página /donaciones';

    public function handle(): int
    {
        $this->call(DonacionesPageSeeder::class);

        return self::SUCCESS;
    }
}
