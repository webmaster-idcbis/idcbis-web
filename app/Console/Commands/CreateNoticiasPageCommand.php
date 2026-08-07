<?php

namespace App\Console\Commands;

use Database\Seeders\NoticiasPageSeeder;
use Illuminate\Console\Command;

class CreateNoticiasPageCommand extends Command
{
    protected $signature = 'page:create-noticias';

    protected $description = 'Crea o actualiza la página /noticias';

    public function handle(): int
    {
        $this->call(NoticiasPageSeeder::class);

        return self::SUCCESS;
    }
}
