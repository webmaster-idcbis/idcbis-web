<?php

namespace App\Support;

/**
 * Reconstruye bloques monolíticos a partir del contenido dividido del editor.
 */
class MergePageContent
{
    public static function mergeDocumentsPage(array $blocks): ?array
    {
        $monolith = self::findBlock($blocks, 'idcbis-documents-page');
        if ($monolith !== null) {
            return self::cleanDocumentsMonolith($monolith);
        }

        $list = self::findBlock($blocks, 'idcbis-documents-list');
        if ($list === null) {
            return null;
        }

        $hero = self::findBlock($blocks, 'hero');
        $intro = self::findBlock($blocks, 'text');
        [$eyebrow, $heroSubtitle] = self::parseHeroSubtitle($hero['subtitle'] ?? '');

        $listId = (string) ($list['id'] ?? 'docs_list');
        $pageId = str_ends_with($listId, '_list')
            ? substr($listId, 0, -strlen('_list')).'_page'
            : $listId.'_page';

        return [
            'id' => $pageId,
            'type' => 'idcbis-documents-page',
            'content' => '',
            'fullBleed' => true,
            'eyebrow' => $eyebrow,
            'heroTitle' => $hero['title'] ?? 'Documentos',
            'heroSubtitle' => $heroSubtitle,
            'heroImage' => $hero['backgroundImage'] ?? '',
            'intro' => $intro['content'] ?? '',
            'layout' => $list['layout'] ?? 'sidebar',
            'documentColumns' => $list['documentColumns'] ?? 1,
            'showSearch' => $list['showSearch'] ?? true,
            'groups' => self::cleanGroups($list['groups'] ?? []),
        ];
    }

    public static function isSplitDocumentsPage(array $blocks): bool
    {
        return self::findBlock($blocks, 'idcbis-documents-list') !== null
            && self::findBlock($blocks, 'idcbis-documents-page') === null;
    }

    public static function cleanDocumentsMonolith(array $data): array
    {
        return [
            'id' => $data['id'] ?? 'docs_page',
            'type' => 'idcbis-documents-page',
            'content' => '',
            'fullBleed' => (bool) ($data['fullBleed'] ?? true),
            'eyebrow' => $data['eyebrow'] ?? '',
            'heroTitle' => $data['heroTitle'] ?? 'Documentos',
            'heroSubtitle' => $data['heroSubtitle'] ?? '',
            'heroImage' => $data['heroImage'] ?? '',
            'intro' => $data['intro'] ?? '',
            'layout' => $data['layout'] ?? 'sidebar',
            'documentColumns' => $data['documentColumns'] ?? 1,
            'showSearch' => $data['showSearch'] ?? true,
            'groups' => self::cleanGroups($data['groups'] ?? []),
        ];
    }

    /** @return array{0: string, 1: string} */
    public static function parseHeroSubtitle(string $subtitle): array
    {
        $subtitle = trim($subtitle);
        if ($subtitle === '') {
            return ['', ''];
        }

        $parts = preg_split('/\r\n|\r|\n/', $subtitle, 2);
        if (count($parts) === 1) {
            return ['', $parts[0]];
        }

        return [$parts[0], $parts[1] ?? ''];
    }

    private static function cleanGroups(array $groups): array
    {
        return array_values(array_map(static function (array $group): array {
            return [
                'id' => $group['id'] ?? '',
                'label' => $group['label'] ?? '',
                'documents' => array_values(array_map(static function (array $document): array {
                    return [
                        'id' => $document['id'] ?? '',
                        'title' => $document['title'] ?? '',
                        'publishedAt' => $document['publishedAt'] ?? '',
                        'url' => $document['url'] ?? '',
                    ];
                }, $group['documents'] ?? [])),
            ];
        }, $groups));
    }

    private static function findBlock(array $blocks, string $type): ?array
    {
        foreach ($blocks as $block) {
            if (is_array($block) && ($block['type'] ?? null) === $type) {
                return $block;
            }
        }

        return null;
    }
}
