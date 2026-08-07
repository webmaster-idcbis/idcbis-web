<?php

namespace App\Console\Commands;

use Database\Seeders\ParticipaPageSeeder;
use Illuminate\Console\Command;

class CreateParticipaPageCommand extends Command
{
    protected $signature = 'page:create-participa';

    protected $description = 'Crea o actualiza la página /participa';

    public function handle(): int
    {
        $this->call(ParticipaPageSeeder::class);

        return self::SUCCESS;
    }
}
