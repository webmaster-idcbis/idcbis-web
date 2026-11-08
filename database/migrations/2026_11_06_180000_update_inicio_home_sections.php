<?php

use App\Models\Menu;
use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pages')) {
            $page = Page::query()->where('slug', 'inicio')->first();

            if ($page) {
                $page->content = $this->transformBlocks($page->content);

                $translations = is_array($page->translations) ? $page->translations : [];
                foreach ($translations as $locale => $payload) {
                    if (is_array($payload) && isset($payload['content']) && is_array($payload['content'])) {
                        $translations[$locale]['content'] = $this->transformBlocks($payload['content']);
                    }
                }
                $page->translations = $translations;
                $page->save();
            }
        }

        if (Schema::hasTable('menus')) {
            Menu::query()->each(function (Menu $menu) {
                $items = is_array($menu->items) ? $menu->items : [];
                $menu->items = $this->renameMenuItems($items);
                $menu->save();
            });
        }
    }

    public function down(): void
    {
        // El bloque de perfiles y el nombre anterior no se restauran:
        // el contenido editorial del Home no debe reescribirse en reversa.
    }

    /**
     * @param  array<int, mixed>|null  $blocks
     * @return array<int, mixed>
     */
    private function transformBlocks(?array $blocks): array
    {
        $blocks = array_values(array_filter(
            $blocks ?? [],
            fn ($block) => ! is_array($block) || ($block['type'] ?? null) !== 'idcbis-audiences'
        ));

        foreach ($blocks as &$block) {
            if (! is_array($block) || ($block['type'] ?? null) !== 'idcbis-services') {
                continue;
            }

            if (! isset($block['cards']) || ! is_array($block['cards'])) {
                continue;
            }

            foreach ($block['cards'] as &$card) {
                if (! is_array($card)) {
                    continue;
                }

                $title = $card['title'] ?? null;
                $id = $card['id'] ?? null;
                $isWellness = $id === 'card_bienestar'
                    || $title === 'Bienestar'
                    || $title === 'Wellness';

                if ($isWellness) {
                    $card['title'] = 'Donaciones';
                }
            }
            unset($card);
        }
        unset($block);

        return $blocks;
    }

    /**
     * @param  array<int, mixed>  $items
     * @return array<int, mixed>
     */
    private function renameMenuItems(array $items): array
    {
        foreach ($items as &$item) {
            if (! is_array($item)) {
                continue;
            }

            $name = $item['name'] ?? null;
            if ($name === 'Bienestar' || $name === 'Wellness') {
                $item['name'] = 'Donaciones';
            } elseif (is_array($name)) {
                $spanish = $name['es'] ?? null;
                $english = $name['en'] ?? null;
                if ($spanish === 'Bienestar' || $english === 'Wellness') {
                    $item['name'] = array_merge($name, [
                        'es' => 'Donaciones',
                        'en' => 'Donations',
                    ]);
                }
            }

            if (isset($item['children']) && is_array($item['children'])) {
                $item['children'] = $this->renameMenuItems($item['children']);
            }
        }
        unset($item);

        return $items;
    }
};
