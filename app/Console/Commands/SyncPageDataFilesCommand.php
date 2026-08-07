<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Support\MergePageContent;
use App\Support\PageDataFileWriter;
use Illuminate\Console\Command;

class SyncPageDataFilesCommand extends Command
{
    protected $signature = 'page:sync-data-files
                            {--slug= : Sincronizar solo un slug}
                            {--dry-run : Mostrar cambios sin escribir archivos}';

    protected $description = 'Sincroniza database/data/* desde el contenido actual de las páginas en la BD';

    /** @var array<string, array{source?: string, monolith?: bool}> */
    private const PAGE_REGISTRY = [
        'ejecucion-presupuestal' => [
            'source' => 'https://idcbis.org.co/ejecucion-presupuestal/',
            'monolith' => true,
        ],
        'contratacion-bienes-servicios' => [
            'source' => 'https://idcbis.org.co/contratacion-bienes-y-servicios/',
            'monolith' => true,
        ],
        'rendicion-de-cuentas' => [
            'source' => 'https://idcbis.org.co/rendicion-de-cuentas/',
            'monolith' => true,
        ],
        'plan-anticorrupcion' => [
            'source' => 'https://idcbis.org.co/plan-anticorrupcion/',
            'monolith' => true,
        ],
        'programa-transparencia-etica-publica' => [
            'source' => 'https://idcbis.org.co/programa-de-transparencia-y-etica-publica/',
            'monolith' => true,
        ],
        'estados-financieros' => [
            'source' => 'https://idcbis.org.co/estados-financieros/',
            'monolith' => true,
        ],
        'quienes-somos' => [
            'source' => 'https://idcbis.org.co/quienes-somos/',
            'monolith' => false,
        ],
        'mapa-del-sitio' => [
            'monolith' => false,
        ],
        'banco-de-sangre' => [
            'monolith' => false,
        ],
        'banco-distrital-de-tejidos' => [
            'source' => 'https://idcbis.org.co/banco-distrital-de-tejidos/',
            'monolith' => false,
        ],
        'darcelulas' => [
            'source' => 'https://idcbis.darcelulas.com.co/',
            'monolith' => false,
        ],
        'contacto' => [
            'monolith' => false,
        ],
        'noticias' => [
            'monolith' => false,
        ],
        'transparencia' => [
            'source' => 'https://idcbis.org.co/transparencia/',
            'monolith' => false,
        ],
        'informacion-de-la-entidad' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/informacion-de-la-entidad',
            'monolith' => false,
        ],
        'normativa' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/normativa',
            'monolith' => false,
        ],
        'contratacion' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/contratacion',
            'monolith' => false,
        ],
        'planeacion-presupuesto-e-informes' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/planeacion',
            'monolith' => false,
        ],
        'tramites' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/tramites',
            'monolith' => false,
        ],
        'datos-abiertos' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/datos-abiertos',
            'monolith' => false,
        ],
        'informacion-grupos-de-interes' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/informacion-especifica-para-grupos-de-interes',
            'monolith' => false,
        ],
        'obligacion-reporte-informacion' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/obligacion-de-reporte-de-informacion',
            'monolith' => false,
        ],
        'informacion-tributaria-entidades-territoriales' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/tributaria',
            'monolith' => false,
        ],
        'participa' => [
            'source' => 'https://idcbis.org.co/transparencia/transparencia/participa',
            'monolith' => false,
        ],
        'atencion-a-usuarios' => [
            'source' => 'https://idcbis.org.co/atencion-a-usuarios/',
            'monolith' => false,
        ],
    ];

    public function handle(): int
    {
        $slugFilter = $this->option('slug');
        $dryRun = (bool) $this->option('dry-run');
        $updated = 0;
        $missing = 0;

        $slugs = $slugFilter
            ? [$slugFilter => self::PAGE_REGISTRY[$slugFilter] ?? ['monolith' => false]]
            : self::PAGE_REGISTRY;

        if ($slugFilter && ! isset(self::PAGE_REGISTRY[$slugFilter])) {
            $this->warn("Slug «{$slugFilter}» no está en el registro; se intentará sincronizar igual.");
        }

        foreach ($slugs as $slug => $config) {
            $page = Page::query()->where('slug', $slug)->first();

            if (! $page) {
                $this->warn("✗ {$slug}: no existe en la base de datos");
                $missing++;

                continue;
            }

            $content = is_array($page->content) ? $page->content : [];
            if ($content === []) {
                $this->warn("✗ {$slug}: content vacío, omitido");
                $missing++;

                continue;
            }

            $contentPath = database_path("data/{$slug}-content.php");
            $pagePath = database_path("data/{$slug}-page.php");
            $metaPath = database_path("data/{$slug}-meta.php");

            $types = implode(', ', array_map(fn ($b) => $b['type'] ?? '?', $content));
            $this->line("→ {$slug} [{$types}]");

            if ($dryRun) {
                $this->comment("  content: {$contentPath}");
                if (($config['monolith'] ?? false) && MergePageContent::mergeDocumentsPage($content)) {
                    $this->comment("  page:    {$pagePath}");
                }
                $this->comment("  meta:    {$metaPath}");
                $updated++;

                continue;
            }

            PageDataFileWriter::writeReturnFile(
                $contentPath,
                $content,
                self::contentHeader($slug),
            );

            if (($config['monolith'] ?? false) && is_file($pagePath)) {
                $monolith = MergePageContent::mergeDocumentsPage($content);
                if ($monolith !== null) {
                    PageDataFileWriter::writeDocumentPageFile(
                        $pagePath,
                        $monolith,
                        $config['source'] ?? '',
                    );
                }
            }

            PageDataFileWriter::writeReturnFile(
                $metaPath,
                [
                    'title' => $page->title,
                    'meta_title' => $page->meta_title,
                    'meta_description' => $page->meta_description,
                    'meta_keywords' => $page->meta_keywords,
                ],
                "/** Metadatos de la página /{$slug} — sincronizado desde la BD */",
            );

            $this->info("✓ {$slug}: archivos actualizados");
            $updated++;
        }

        $this->newLine();
        $this->info("Páginas sincronizadas: {$updated}");
        if ($missing > 0) {
            $this->warn("Páginas omitidas/no encontradas: {$missing}");
        }

        if (! $dryRun && $updated > 0) {
            $this->comment('Ejecuta php artisan test --filter=SyncPageDataFilesTest para validar.');
        }

        return self::SUCCESS;
    }

    private static function contentHeader(string $slug): string
    {
        return <<<PHP
/**
 * Contenido de /{$slug} tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */
PHP;
    }
}
