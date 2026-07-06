<?php

namespace Database\Seeders;

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Seeder;

class EstadosFinancierosPageSeeder extends Seeder
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

        $content = require database_path('data/estados-financieros-content.php');

        $page = Page::withTrashed()->updateOrCreate(
            ['slug' => 'estados-financieros'],
            [
                'title' => 'Estados Financieros | IDCBIS',
                'meta_title' => 'Estados Financieros — IDCBIS',
                'meta_description' => 'Estados financieros del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud, organizados por período de corte.',
                'meta_keywords' => 'IDCBIS, estados financieros, transparencia, información pública, Bogotá',
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
            $this->command->info('Página creada/actualizada: /estados-financieros');
        }
    }
}
