<?php

namespace App\Console\Commands;

use Database\Seeders\BancoDeSangrePageSeeder;
use Illuminate\Console\Command;

class CreateBancoDeSangrePageCommand extends Command
{
    protected $signature = 'page:create-banco-de-sangre';

    protected $description = 'Crea o actualiza la página /banco-de-sangre';

    public function handle(): int
    {
        $this->call(BancoDeSangrePageSeeder::class);

        return self::SUCCESS;
    }
}
