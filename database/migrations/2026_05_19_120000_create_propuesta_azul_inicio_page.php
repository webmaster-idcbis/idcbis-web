<?php

use App\Models\Page;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('pages') || ! Schema::hasTable('users')) {
            return;
        }

        if (Page::withTrashed()->where('slug', 'inicio')->exists()) {
            return;
        }

        $user = User::query()->first();
        if (! $user) {
            return;
        }

        $content = require database_path('data/propuesta-azul-content.php');

        Page::create([
            'title' => 'IDCBIS | Ciencia que te conecta con la vida',
            'slug' => 'inicio',
            'meta_description' => 'Donar sangre, tejidos o cordón umbilical. Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud.',
            'meta_title' => 'IDCBIS | Ciencia que te conecta con la vida',
            'meta_keywords' => 'IDCBIS, donación, sangre, tejidos, cordón umbilical, Bogotá',
            'content' => $content,
            'sections' => [],
            'status' => 'published',
            'published_at' => now(),
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);
    }

    public function down(): void
    {
        Page::withTrashed()->where('slug', 'inicio')->forceDelete();
    }
};
