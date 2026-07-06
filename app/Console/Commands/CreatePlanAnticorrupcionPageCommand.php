<?php

namespace App\Console\Commands;

use Database\Seeders\PlanAnticorrupcionPageSeeder;
use Illuminate\Console\Command;

class CreatePlanAnticorrupcionPageCommand extends Command
{
    protected $signature = 'page:create-plan-anticorrupcion';

    protected $description = 'Crea o actualiza la página /plan-anticorrupcion';

    public function handle(): int
    {
        $this->call(PlanAnticorrupcionPageSeeder::class);

        return self::SUCCESS;
    }
}
