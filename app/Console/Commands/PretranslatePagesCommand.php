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
        $total = $pages->count();

        foreach ($pages as $page) {
            $translations = is_array($page->translations) ? $page->translations : [];

            $this->writeProgress($page->slug, $done, $skipped, $total, 'running');

            $curatedFile = database_path('data/'.$page->slug.'-translations.php');
            if (is_file($curatedFile)) {
                $curated = require $curatedFile;
                if (is_array($curated)) {
                    $page->translations = array_replace($translations, $curated);
                    $page->save();
                    $skipped++;
                    $bar->advance();
                    continue;
                }
            }

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
            if ($this->translationMatchesSource($payload, $translated)) {
                $this->writeProgress($page->slug, $done, $skipped, $total, 'unchanged');
                $skipped++;
                $bar->advance();
                continue;
            }

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
        $this->writeProgress('', $done, $skipped, $total, 'done');

        return self::SUCCESS;
    }

    private function translationMatchesSource(array $source, mixed $translated): bool
    {
        if (! is_array($translated)) {
            return true;
        }

        $left = $this->comparableTexts($source);
        $right = $this->comparableTexts($translated);
        if ($left === []) {
            return false;
        }

        $limit = min(count($left), count($right));
        if ($limit === 0) {
            return true;
        }

        $same = 0;
        for ($i = 0; $i < $limit; $i++) {
            if ($left[$i] === $right[$i]) {
                $same++;
            }
        }

        return ($same / $limit) > 0.85;
    }

    private function comparableTexts(mixed $value): array
    {
        $out = [];
        $this->collectComparableTexts($value, $out);

        return $out;
    }

    private function collectComparableTexts(mixed $value, array &$out): void
    {
        if (is_string($value)) {
            $text = trim($value);
            if (mb_strlen($text) >= 24 && preg_match('/\p{L}/u', $text)) {
                $out[] = $text;
            }

            return;
        }

        if (! is_array($value)) {
            return;
        }

        foreach ($value as $item) {
            $this->collectComparableTexts($item, $out);
        }
    }

    private function writeProgress(string $slug, int $done, int $skipped, int $total, string $state): void
    {
        $path = storage_path('app/pretranslate-status.json');
        file_put_contents($path, json_encode([
            'state' => $state,
            'slug' => $slug,
            'done' => $done,
            'skipped' => $skipped,
            'total' => $total,
            'at' => date('c'),
        ], JSON_UNESCAPED_UNICODE));
    }
}
