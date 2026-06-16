<?php

namespace App\Console\Commands;

use App\Models\Page;
use App\Services\PageSearchIndexer;
use Illuminate\Console\Command;

class ReindexPagesSearchCommand extends Command
{
    protected $signature = 'pages:reindex-search';

    protected $description = 'Regenera el índice de búsqueda de todas las páginas';

    public function handle(): int
    {
        $count = 0;

        Page::query()->chunkById(50, function ($pages) use (&$count) {
            foreach ($pages as $page) {
                $page->search_text = PageSearchIndexer::buildSearchText($page);
                $page->saveQuietly();
                $count++;
            }
        });

        $this->info("Índice de búsqueda actualizado para {$count} páginas.");

        return self::SUCCESS;
    }
}
