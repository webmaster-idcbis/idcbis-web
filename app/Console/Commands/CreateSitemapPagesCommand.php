<?php

namespace App\Console\Commands;

use Database\Seeders\MapaDelSitioPageSeeder;
use Database\Seeders\SitemapPagesSeeder;
use Illuminate\Console\Command;

class CreateSitemapPagesCommand extends Command
{
    protected $signature = 'pages:create-sitemap';

    protected $description = 'Crea la página del mapa del sitio y las páginas placeholder';

    public function handle(): int
    {
        $this->call(MapaDelSitioPageSeeder::class);
        $this->call(SitemapPagesSeeder::class);

        return self::SUCCESS;
    }
}
