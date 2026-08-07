<?php

namespace App\Support;

class PageDataFileWriter
{
    public static function writeReturnFile(string $path, array $data, string $header = ''): void
    {
        $dir = dirname($path);
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $body = "<?php\n\n";
        if ($header !== '') {
            $body .= rtrim($header)."\n\n";
        }
        $body .= 'return '.self::export($data).";\n";

        file_put_contents($path, $body);
    }

    public static function writeDocumentPageFile(string $path, array $monolith, string $sourceUrl): void
    {
        $header = <<<PHP
/**
 * Bloque idcbis-documents-page — {$monolith['heroTitle']}.
 * Fuente: {$sourceUrl}
 *
 * Generado/sincronizado desde la base de datos con page:sync-data-files
 */

\$doc = static function (
    string \$id,
    string \$title,
    string \$publishedAt = '',
    string \$url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

PHP;

        $groupsExport = self::exportDocumentGroups($monolith['groups'] ?? []);

        $body = "<?php\n\n".$header."\n";
        $pageMeta = [
            'id' => $monolith['id'] ?? 'docs_page',
            'type' => 'idcbis-documents-page',
            'content' => '',
            'fullBleed' => (bool) ($monolith['fullBleed'] ?? true),
            'eyebrow' => $monolith['eyebrow'] ?? '',
            'heroTitle' => $monolith['heroTitle'] ?? 'Documentos',
            'heroSubtitle' => $monolith['heroSubtitle'] ?? '',
            'intro' => $monolith['intro'] ?? '',
            'layout' => $monolith['layout'] ?? 'sidebar',
            'documentColumns' => $monolith['documentColumns'] ?? 1,
            'showSearch' => (bool) ($monolith['showSearch'] ?? true),
        ];

        if (! empty($monolith['heroImage'])) {
            $pageMeta['heroImage'] = $monolith['heroImage'];
        }

        $body .= '$page = '.self::export($pageMeta, 0);
        // Cierra el array parcialmente para inyectar 'groups' antes del ]; final
        $body = preg_replace('/\]\s*$/', ',', rtrim($body));
        $body .= "\n    'groups' => {$groupsExport},\n";
        $body .= "];\n\nreturn \$page;\n";

        file_put_contents($path, $body);
    }

    public static function export(mixed $value, int $indent = 0, bool $trailingSemicolon = false): string
    {
        $pad = str_repeat('    ', $indent);

        if (is_array($value)) {
            if ($value === []) {
                return '[]';
            }

            $isList = array_keys($value) === range(0, count($value) - 1);
            $lines = ['['];

            foreach ($value as $key => $item) {
                $linePad = str_repeat('    ', $indent + 1);
                // Nested arrays must NOT end with ';' — callers append ',' or ';' as needed.
                if ($isList) {
                    $lines[] = $linePad.self::export($item, $indent + 1, false).',';
                } else {
                    $lines[] = $linePad.self::exportKey($key).' => '.self::export($item, $indent + 1, false).',';
                }
            }

            $lines[] = $pad.']';

            $result = implode("\n", $lines);

            return $trailingSemicolon ? $result.';' : $result;
        }

        if (is_string($value)) {
            return "'".addcslashes($value, "\\'")."'";
        }

        if (is_bool($value)) {
            return $value ? 'true' : 'false';
        }

        if ($value === null) {
            return 'null';
        }

        if (is_int($value) || is_float($value)) {
            return (string) $value;
        }

        return var_export($value, true);
    }

    private static function exportDocumentGroups(array $groups): string
    {
        if ($groups === []) {
            return '[]';
        }

        $lines = ['['];

        foreach ($groups as $group) {
            $lines[] = '        [';
            $lines[] = "            'id' => ".self::export($group['id'] ?? '').',';
            $lines[] = "            'label' => ".self::export($group['label'] ?? '').',';
            $lines[] = "            'documents' => [";

            foreach ($group['documents'] ?? [] as $document) {
                $lines[] = '                $doc('
                    .self::export($document['id'] ?? '').', '
                    .self::export($document['title'] ?? '');

                $publishedAt = $document['publishedAt'] ?? '';
                $url = $document['url'] ?? '';

                if ($publishedAt !== '' || $url !== '') {
                    $lines[count($lines) - 1] .= ', '.self::export($publishedAt);
                    if ($url !== '') {
                        $lines[count($lines) - 1] .= ', '.self::export($url);
                    }
                }

                $lines[count($lines) - 1] .= '),';
            }

            $lines[] = '            ],';
            $lines[] = '        ],';
        }

        $lines[] = '    ]';

        return implode("\n", $lines);
    }

    private static function exportKey(int|string $key): string
    {
        if (is_int($key)) {
            return (string) $key;
        }

        return "'".addcslashes($key, "\\'")."'";
    }
}
