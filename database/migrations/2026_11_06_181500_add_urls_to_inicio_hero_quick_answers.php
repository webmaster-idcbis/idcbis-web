<?php

use App\Models\Page;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /** @var array<string, string> */
    private array $urlsById = [
        'qa_que_es' => '/quienes-somos',
        'qa_que_hacemos' => '/investigacion',
        'qa_que_puedes' => '#servicios',
    ];

    /** @var array<string, string> */
    private array $urlsByQuestion = [
        '¿Qué es IDCBIS?' => '/quienes-somos',
        'What is IDCBIS?' => '/quienes-somos',
        '¿Qué hacemos?' => '/investigacion',
        'What do we do?' => '/investigacion',
        '¿Qué puedes hacer aquí?' => '#servicios',
        'What can you do here?' => '#servicios',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        $page = Page::query()->where('slug', 'inicio')->first();
        if (! $page) {
            return;
        }

        $page->content = $this->withQuickAnswerUrls($page->content);

        $translations = is_array($page->translations) ? $page->translations : [];
        foreach ($translations as $locale => $payload) {
            if (is_array($payload) && isset($payload['content']) && is_array($payload['content'])) {
                $translations[$locale]['content'] = $this->withQuickAnswerUrls($payload['content']);
            }
        }
        $page->translations = $translations;
        $page->save();
    }

    public function down(): void
    {
        if (! Schema::hasTable('pages')) {
            return;
        }

        $page = Page::query()->where('slug', 'inicio')->first();
        if (! $page) {
            return;
        }

        $page->content = $this->withoutQuickAnswerUrls($page->content);

        $translations = is_array($page->translations) ? $page->translations : [];
        foreach ($translations as $locale => $payload) {
            if (is_array($payload) && isset($payload['content']) && is_array($payload['content'])) {
                $translations[$locale]['content'] = $this->withoutQuickAnswerUrls($payload['content']);
            }
        }
        $page->translations = $translations;
        $page->save();
    }

    /**
     * @param  array<int, mixed>|null  $blocks
     * @return array<int, mixed>
     */
    private function withQuickAnswerUrls(?array $blocks): array
    {
        $blocks = $blocks ?? [];

        foreach ($blocks as &$block) {
            if (! is_array($block) || ($block['type'] ?? null) !== 'idcbis-hero-carousel') {
                continue;
            }
            if (! isset($block['quickAnswers']) || ! is_array($block['quickAnswers'])) {
                continue;
            }

            foreach ($block['quickAnswers'] as &$item) {
                if (! is_array($item)) {
                    continue;
                }

                $id = $item['id'] ?? null;
                $question = $item['question'] ?? null;

                if (is_string($id) && isset($this->urlsById[$id])) {
                    $item['url'] = $this->urlsById[$id];
                    continue;
                }

                if (is_string($question) && isset($this->urlsByQuestion[$question])) {
                    $item['url'] = $this->urlsByQuestion[$question];
                }
            }
            unset($item);
        }
        unset($block);

        return $blocks;
    }

    /**
     * @param  array<int, mixed>|null  $blocks
     * @return array<int, mixed>
     */
    private function withoutQuickAnswerUrls(?array $blocks): array
    {
        $blocks = $blocks ?? [];

        foreach ($blocks as &$block) {
            if (! is_array($block) || ($block['type'] ?? null) !== 'idcbis-hero-carousel') {
                continue;
            }
            if (! isset($block['quickAnswers']) || ! is_array($block['quickAnswers'])) {
                continue;
            }

            foreach ($block['quickAnswers'] as &$item) {
                if (is_array($item)) {
                    unset($item['url']);
                }
            }
            unset($item);
        }
        unset($block);

        return $blocks;
    }
};
