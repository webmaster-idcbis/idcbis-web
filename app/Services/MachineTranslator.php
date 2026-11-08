<?php

namespace App\Services;

use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class MachineTranslator
{
    private const SKIP_KEYS = [
        'id', 'type', 'name', 'icon', 'href', 'url', 'src', 'image', 'imageAlt',
        'backgroundImage', 'backgroundColor', 'color', 'padding', 'borderRadius',
        'minHeight', 'textAlign', 'layout', 'fullBleed', 'required', 'rows',
        'columns', 'limit', 'order', 'status', 'slug', 'publishedAt', 'publishedAtIso',
        'class', 'target', 'rel', 'blockLabel', 'theme',
    ];

    public function driver(): string
    {
        return config('translation.driver', 'gtx');
    }

    /**
     * Traduce un árbol de contenido (arrays/objetos JSON del CMS).
     */
    public function translateTree(mixed $value, string $target = 'en', string $source = 'es'): mixed
    {
        if ($target === $source) {
            return $value;
        }

        $unique = [];
        $this->collectStrings($value, $unique);

        $map = $this->translateMany(array_keys($unique), $target, $source);

        return $this->applyMap($value, $map);
    }

    /**
     * @param  list<string>  $texts
     * @return array<string, string>
     */
    public function translateMany(array $texts, string $target = 'en', string $source = 'es'): array
    {
        $map = [];
        $pending = [];

        foreach ($texts as $text) {
            if (! is_string($text)) {
                continue;
            }

            $trimmed = trim($text);
            if ($trimmed === '' || $this->shouldSkipString($trimmed)) {
                $map[$text] = $text;
                continue;
            }

            $cacheKey = 'mt:'.$this->driver().':'.md5($source.'|'.$target.'|'.$trimmed);
            $cached = Cache::get($cacheKey);
            if (is_string($cached) && ! $this->isUnchangedTranslation($trimmed, $cached)) {
                $map[$text] = $cached;
                continue;
            }

            $pending[$text] = $cacheKey;
        }

        if ($pending === []) {
            return $map;
        }

        $driver = $this->driver();

        foreach (array_chunk(array_keys($pending), 3) as $chunk) {
            $translatedChunk = $driver === 'libretranslate'
                ? $this->translateChunkSequential($chunk, $target, $source)
                : $this->translateChunkWithGtx($chunk, $target, $source);

            foreach ($chunk as $text) {
                $translated = $translatedChunk[$text] ?? null;
                if (! is_string($translated) || $translated === '' || $this->isUnchangedTranslation($text, $translated)) {
                    $map[$text] = $text;
                    continue;
                }

                Cache::put($pending[$text], $translated, now()->addDays(30));
                $map[$text] = $translated;
            }

            usleep(250000);
        }

        return $map;
    }

    /**
     * @param  list<string>  $chunk
     * @return array<string, string>
     */
    private function translateChunkSequential(array $chunk, string $target, string $source): array
    {
        $translated = [];

        foreach ($chunk as $text) {
            $translated[$text] = $this->requestTranslation($text, $target, $source);
        }

        return $translated;
    }

    /**
     * @param  list<string>  $chunk
     * @return array<string, string>
     */
    private function translateChunkWithGtx(array $chunk, string $target, string $source): array
    {
        $pending = array_values($chunk);
        $translated = [];

        for ($attempt = 0; $attempt < 5 && $pending !== []; $attempt++) {
            if ($attempt > 0) {
                sleep(min(20, 2 ** $attempt));
            }

            try {
                $responses = Http::pool(function (Pool $pool) use ($pending, $target, $source) {
                    foreach ($pending as $index => $text) {
                    $pool->as((string) $index)
                        ->timeout(15)
                        ->withHeaders([
                            'User-Agent' => 'Mozilla/5.0 (compatible; IDCBIS-CMS/1.0)',
                        ])
                        ->get('https://clients5.google.com/translate_a/t', [
                            'client' => 'dict-chrome-ex',
                            'sl' => $source,
                            'tl' => $target,
                            'q' => $text,
                        ]);
                    }
                });
            } catch (Throwable $e) {
                Log::warning('MachineTranslator batch failed', ['message' => $e->getMessage()]);
                sleep(3);
                continue;
            }

            $retry = [];

            foreach ($pending as $index => $text) {
                $response = $responses[(string) $index] ?? null;
                if (! $response instanceof Response) {
                    $retry[] = $text;
                    continue;
                }

                if ($response->status() === 429 || $response->serverError()) {
                    $retry[] = $text;
                    continue;
                }

                if ($response->successful()) {
                    $parsed = $this->parseClients5Response($response->json());
                    $translated[$text] = is_string($parsed) && $parsed !== '' ? $parsed : $text;
                    continue;
                }

                $translated[$text] = $text;
            }

            $pending = $retry;
        }

        return $translated;
    }

    private function requestTranslation(string $text, string $target, string $source): string
    {
        try {
            return match ($this->driver()) {
                'libretranslate' => $this->translateWithLibreTranslate($text, $target, $source),
                default => $this->translateWithGtx($text, $target, $source),
            };
        } catch (Throwable $e) {
            Log::warning('MachineTranslator failed', [
                'driver' => $this->driver(),
                'message' => $e->getMessage(),
            ]);

            return $text;
        }
    }

    private function translateWithLibreTranslate(string $text, string $target, string $source): string
    {
        $baseUrl = rtrim((string) config('translation.libretranslate.url', 'http://127.0.0.1:5000'), '/');
        $apiKey = config('translation.libretranslate.api_key');

        $payload = [
            'q' => $text,
            'source' => $source,
            'target' => $target,
            'format' => 'text',
        ];

        if ($apiKey) {
            $payload['api_key'] = $apiKey;
        }

        $response = Http::timeout(30)
            ->acceptJson()
            ->post($baseUrl.'/translate', $payload);

        if (! $response->successful()) {
            return $text;
        }

        $translated = $response->json('translatedText');

        return is_string($translated) && $translated !== '' ? $translated : $text;
    }

    private function translateWithGtx(string $text, string $target, string $source): string
    {
        $response = Http::timeout(12)
            ->withHeaders([
                'User-Agent' => 'Mozilla/5.0 (compatible; IDCBIS-CMS/1.0)',
            ])
            ->get('https://clients5.google.com/translate_a/t', [
                'client' => 'dict-chrome-ex',
                'sl' => $source,
                'tl' => $target,
                'q' => $text,
            ]);

        if (! $response->successful()) {
            return $text;
        }

        return $this->parseClients5Response($response->json()) ?: $text;
    }

    private function collectStrings(mixed $value, array &$unique, ?string $key = null): void
    {
        if (is_string($value)) {
            if ($key === null || ! $this->shouldSkipKey($key)) {
                $unique[$value] = true;
            }

            return;
        }

        if (! is_array($value)) {
            return;
        }

        $isList = array_keys($value) === range(0, count($value) - 1);

        foreach ($value as $childKey => $item) {
            if (! $isList && is_string($childKey) && $this->shouldSkipKey($childKey)) {
                continue;
            }

            $this->collectStrings($item, $unique, is_string($childKey) ? $childKey : $key);
        }
    }

    private function applyMap(mixed $value, array $map, ?string $key = null): mixed
    {
        if (is_string($value)) {
            if ($key !== null && $this->shouldSkipKey($key)) {
                return $value;
            }

            return $map[$value] ?? $value;
        }

        if (! is_array($value)) {
            return $value;
        }

        $isList = array_keys($value) === range(0, count($value) - 1);
        $result = [];

        foreach ($value as $childKey => $item) {
            if (! $isList && is_string($childKey) && $this->shouldSkipKey($childKey)) {
                $result[$childKey] = $item;
                continue;
            }

            $result[$childKey] = $this->applyMap(
                $item,
                $map,
                is_string($childKey) ? $childKey : $key,
            );
        }

        return $result;
    }

    private function shouldSkipKey(string $key): bool
    {
        if (in_array($key, self::SKIP_KEYS, true)) {
            return true;
        }

        return (bool) preg_match('/(color|image|url|href|src|class|icon|padding|margin|width|height|radius|gradient)/i', $key);
    }

    private function isUnchangedTranslation(string $source, string $translated): bool
    {
        return trim($source) === trim($translated);
    }

    private function shouldSkipString(string $text): bool
    {
        if (preg_match('/<\s*\/?\s*[a-z!][^>]*>/i', $text)) {
            return true;
        }
        if (preg_match('#^(https?:)?//#i', $text)) {
            return true;
        }
        if (preg_match('/^[\w.+-]+@[\w.-]+\.[a-z]{2,}$/i', $text)) {
            return true;
        }
        if (preg_match('/^#[0-9a-f]{3,8}$/i', $text)) {
            return true;
        }
        if (preg_match('/^(rgb|hsl|linear-gradient|var\()/i', $text)) {
            return true;
        }
        if (! preg_match('/\p{L}/u', $text)) {
            return true;
        }
        if (! preg_match('/\s/u', $text) && preg_match('/^\/?[\w\-.\/]+$/', $text) && strlen($text) < 80) {
            // Rutas, archivos e identificadores. Las palabras sueltas (Servicios, Organigrama) sí se traducen.
            if (preg_match('/[\/_\-.]/', $text) || preg_match('/\d/', $text) || strlen($text) <= 2) {
                return true;
            }

            return false;
        }

        return false;
    }

    private function parseClients5Response(mixed $json): ?string
    {
        if (is_string($json)) {
            $trimmed = trim($json);

            return $trimmed !== '' ? $trimmed : null;
        }

        if (is_array($json) && isset($json[0]) && is_string($json[0]) && trim($json[0]) !== '') {
            return $json[0];
        }

        return $this->parseGoogleResponse($json);
    }

    private function parseGoogleResponse(mixed $json): ?string
    {
        if (! is_array($json) || ! isset($json[0]) || ! is_array($json[0])) {
            return null;
        }

        $translated = '';
        foreach ($json[0] as $chunk) {
            if (is_array($chunk) && isset($chunk[0]) && is_string($chunk[0])) {
                $translated .= $chunk[0];
            }
        }

        return $translated !== '' ? $translated : null;
    }
}
