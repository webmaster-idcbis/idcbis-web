<?php

namespace App\Services;

use App\Models\Page;

class PageSearchIndexer
{
    private const SKIP_KEYS = [
        'id', 'type', 'href', 'url', 'image', 'og_image', 'backgroundImage',
        'background', 'icon', 'slug', 'className', 'fontFamily', 'fontSize',
        'fontWeight', 'color', 'border', 'borderRadius', 'boxShadow', 'padding',
        'margin', 'width', 'height', 'minHeight', 'maxWidth', 'display',
        'flexDirection', 'alignItems', 'justifyContent', 'gridTemplateColumns',
        'target', 'page_id', 'variant', 'level', 'size', 'interval',
    ];

    public static function buildSearchText(Page $page): string
    {
        $parts = array_filter([
            $page->title,
            $page->meta_title,
            $page->meta_description,
            $page->meta_keywords,
        ]);

        if (is_array($page->content)) {
            $parts[] = self::extractFromArray($page->content);
        }

        if (is_array($page->sections)) {
            $parts[] = self::extractFromArray($page->sections);
        }

        $text = implode(' ', $parts);
        $text = strip_tags($text);
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        $text = preg_replace('/\s+/u', ' ', $text);

        return trim(mb_substr($text, 0, 65000));
    }

    public static function excerpt(string $searchText, string $query, int $length = 180): string
    {
        if ($searchText === '') {
            return '';
        }

        $position = self::findMatchPosition($searchText, $query);

        if ($position === false) {
            $snippet = mb_substr($searchText, 0, $length);
            return mb_strlen($searchText) > $length ? rtrim($snippet) . '…' : $snippet;
        }

        $start = max(0, $position - 60);
        $snippet = mb_substr($searchText, $start, $length);
        $prefix = $start > 0 ? '…' : '';
        $suffix = ($start + $length) < mb_strlen($searchText) ? '…' : '';

        return $prefix . trim($snippet) . $suffix;
    }

    public static function relevanceScore(Page $page, string $query, array $terms): int
    {
        $score = 0;
        $title = mb_strtolower($page->title ?? '');
        $meta = mb_strtolower(($page->meta_description ?? '') . ' ' . ($page->meta_keywords ?? ''));
        $body = mb_strtolower($page->search_text ?? '');
        $queryLower = mb_strtolower($query);

        if ($title === $queryLower) {
            $score += 100;
        } elseif (str_contains($title, $queryLower)) {
            $score += 60;
        }

        foreach ($terms as $term) {
            $termLower = mb_strtolower($term);
            if (str_contains($title, $termLower)) {
                $score += 20;
            }
            if (str_contains($meta, $termLower)) {
                $score += 10;
            }
            if (str_contains($body, $termLower)) {
                $score += 5;
            }
        }

        return $score;
    }

    private static function extractFromArray(array $data): string
    {
        $parts = [];

        foreach ($data as $key => $value) {
            if (is_string($value)) {
                if (self::isSearchableString((string) $key, $value)) {
                    $parts[] = $value;
                }
            } elseif (is_array($value)) {
                $parts[] = self::extractFromArray($value);
            } elseif (is_numeric($value)) {
                $parts[] = (string) $value;
            }
        }

        return implode(' ', array_filter($parts));
    }

    private static function isSearchableString(string $key, string $value): bool
    {
        if ($value === '' || in_array($key, self::SKIP_KEYS, true)) {
            return false;
        }

        if (preg_match('/^#[0-9a-fA-F]{3,8}$/', $value)) {
            return false;
        }

        if (preg_match('/^https?:\/\//', $value)) {
            return false;
        }

        if (preg_match('/^\/(img|images|fonts|storage)\//', $value)) {
            return false;
        }

        if (preg_match('/^[a-f0-9-]{20,}$/i', $value)) {
            return false;
        }

        if (strlen($value) > 400 && !str_contains($value, ' ')) {
            return false;
        }

        return true;
    }

    private static function findMatchPosition(string $text, string $query): int|false
    {
        $position = mb_stripos($text, $query);
        if ($position !== false) {
            return $position;
        }

        foreach (preg_split('/\s+/u', trim($query)) as $term) {
            if (mb_strlen($term) < 2) {
                continue;
            }
            $position = mb_stripos($text, $term);
            if ($position !== false) {
                return $position;
            }
        }

        return false;
    }
}
