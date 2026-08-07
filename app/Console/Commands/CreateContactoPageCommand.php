<?php

namespace App\Console\Commands;

use Database\Seeders\ContactoPageSeeder;
use Illuminate\Console\Command;

class CreateContactoPageCommand extends Command
{
    protected $signature = 'page:create-contacto';

    protected $description = 'Crea o actualiza la página /contacto';

    public function handle(): int
    {
        $this->call(ContactoPageSeeder::class);

        return self::SUCCESS;
    }
}
