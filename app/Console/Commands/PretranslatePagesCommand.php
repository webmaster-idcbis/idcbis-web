<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Services\MachineTranslator;
use Illuminate\Console\Command;

class PretranslatePagesCommand extends Command
{
    protected $signature = 'pages:pretranslate
                            {--locale=en : Locale destino}
                            {--slug= : Solo una página (slug)}
                            {--force : Regenerar aunque ya exista traducción}';

    protected $description = 'Pregenera traducciones de páginas publicadas y las guarda en pages.translations (cambio de idioma instantáneo en el front)';

    public function handle(MachineTranslator $translator): int
    {
        $locale = (string) $this->option('locale');
        $slug = $this->option('slug');
        $force = (bool) $this->option('force');

        $this->info('Driver: '.$translator->driver());

        $query = Page::query()->where('status', 'published');
        if (is_string($slug) && $slug !== '') {
            $query->where('slug', $slug);
        }

        $pages = $query->orderBy('slug')->get();
        if ($pages->isEmpty()) {
            $this->warn('No hay páginas para traducir.');

            return self::SUCCESS;
        }

        $bar = $this->output->createProgressBar($pages->count());
        $bar->start();

        $done = 0;
        $skipped = 0;

        foreach ($pages as $page) {
            $translations = is_array($page->translations) ? $page->translations : [];

            if (! $force && ! empty($translations[$locale]['content'])) {
                $skipped++;
                $bar->advance();
                continue;
            }

            $payload = [
                'title' => $page->title,
                'meta_title' => $page->meta_title,
                'meta_description' => $page->meta_description,
                'meta_keywords' => $page->meta_keywords,
                'content' => $page->content,
                'sections' => $page->sections,
            ];

            $translated = $translator->translateTree($payload, $locale, 'es');
            $translations[$locale] = $translated;
            $page->translations = $translations;
            $page->save();

            $done++;
            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Traducidas: {$done}. Omitidas (ya existían): {$skipped}.");
        $this->line('En el sitio, el cambio ES/EN usa estas traducciones guardadas (instantáneo).');

        return self::SUCCESS;
    }
}
