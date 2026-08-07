<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Support\SplitPageContent;
use Illuminate\Console\Command;

class SplitMonolithicPagesCommand extends Command
{
    protected $signature = 'page:split-monolithic {--slug= : Solo migrar un slug específico}';

    protected $description = 'Divide páginas monolíticas en bloques editables separados (quienes-somos, documentos, etc.)';

    private const SLUGS_WITH_SPLIT_DATA = [
        'quienes-somos',
        'estados-financieros',
        'plan-anticorrupcion',
        'programa-transparencia-etica-publica',
        'ejecucion-presupuestal',
        'contratacion-bienes-servicios',
        'rendicion-de-cuentas',
        'mapa-del-sitio',
        'banco-de-sangre',
        'banco-distrital-de-tejidos',
    ];

    public function handle(): int
    {
        $slugFilter = $this->option('slug');
        $updated = 0;

        $query = Page::query();
        if ($slugFilter) {
            $query->where('slug', $slugFilter);
        }

        foreach ($query->get() as $page) {
            $content = $page->content;
            if (! is_array($content) || $content === []) {
                continue;
            }

            $needsSplit = collect($content)->contains(
                fn ($el) => is_array($el) && in_array($el['type'] ?? '', ['idcbis-quienes-somos', 'idcbis-documents-page'], true)
            );

            if (! $needsSplit && ! in_array($page->slug, self::SLUGS_WITH_SPLIT_DATA, true)) {
                continue;
            }

            if (in_array($page->slug, self::SLUGS_WITH_SPLIT_DATA, true)) {
                $dataFile = database_path("data/{$page->slug}-content.php");
                if (is_file($dataFile)) {
                    $content = require $dataFile;
                    $page->update(['content' => $content, 'sections' => []]);
                    $this->line("✓ {$page->slug}: ".count($content).' bloques (desde data)');
                    $updated++;

                    continue;
                }
            }

            $split = SplitPageContent::split($content);
            if (count($split) !== count($content)) {
                $page->update(['content' => $split, 'sections' => []]);
                $this->line("✓ {$page->slug}: ".count($content).' → '.count($split).' bloques');
                $updated++;
            }
        }

        $this->info("Páginas actualizadas: {$updated}");

        return self::SUCCESS;
    }
}
