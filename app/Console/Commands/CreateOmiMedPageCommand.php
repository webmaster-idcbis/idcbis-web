<?php

namespace App\Console\Commands;

use Database\Seeders\OmiMedPageSeeder;
use Illuminate\Console\Command;

class CreateOmiMedPageCommand extends Command
{
    protected $signature = 'page:create-omimed';

    protected $description = 'Crea o actualiza la página /omimed';

    public function handle(): int
    {
        $this->call(OmiMedPageSeeder::class);

        return self::SUCCESS;
    }
}
