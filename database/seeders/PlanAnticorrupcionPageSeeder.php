<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlanAnticorrupcionPageSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::query()->where('email', 'admin@idcbis.gov.co')->first()
            ?? User::query()->first();

        if (! $user) {
            if ($this->command) {
                $this->command->error('No hay usuarios. Ejecuta: php artisan db:seed --class=AdminUserSeeder');
            }

            return;
        }

        $content = require database_path('data/plan-anticorrupcion-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'plan-anticorrupcion'],
            [
                'title' => 'Plan anticorrupción | IDCBIS',
                'meta_title' => 'Plan anticorrupción — IDCBIS',
                'meta_description' => 'Plan Anticorrupción y de Atención al Ciudadano (PAAC) del IDCBIS. Consulta planes y seguimientos por vigencia.',
                'meta_keywords' => 'IDCBIS, plan anticorrupción, PAAC, transparencia, información pública, Bogotá',
                'content' => $content,
                'sections' => [],
                'status' => 'published',
                'published_at' => now(),
                'created_by' => $user->id,
                'updated_by' => $user->id,
                'deleted_at' => null,
            ]
        );

        if ($page->trashed()) {
            $page->restore();
        }

        if ($this->command) {
            $this->command->info('Página creada/actualizada: /plan-anticorrupcion');
            $this->command->comment('Agrega URLs de PDF en database/data/plan-anticorrupcion-page.php');
        }
    }
}
