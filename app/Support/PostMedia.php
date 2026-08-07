<?php

namespace App\Support;

class PostMedia
{
    public static function directory(): string
    {
        $dir = public_path('uploads/posts');

        if (! is_dir($dir)) {
            mkdir($dir, 0775, true);
        }

        return $dir;
    }

    public static function storeFromBinary(string $binary, string $extension): string
    {
        $extension = strtolower(preg_replace('/[^a-z0-9]/', '', $extension) ?: 'jpg');
        $filename = uniqid('post_', true).'.'.$extension;

        file_put_contents(self::directory().DIRECTORY_SEPARATOR.$filename, $binary);

        return '/uploads/posts/'.$filename;
    }

    public static function persistIfDataUrl(?string $value): string
    {
        if (! $value) {
            return '';
        }

        if (! str_starts_with($value, 'data:image/')) {
            return self::normalizeUrl($value);
        }

        if (! preg_match('#^data:image/(?<type>jpeg|jpg|png|webp|gif);base64,(?<payload>.+)$#is', $value, $matches)) {
            return '';
        }

        $binary = base64_decode($matches['payload'], true);

        if ($binary === false) {
            return '';
        }

        if (strlen($binary) > 2 * 1024 * 1024) {
            return '';
        }

        if (@getimagesizefromstring($binary) === false) {
            return '';
        }

        $extension = strtolower($matches['type'] === 'jpeg' ? 'jpg' : $matches['type']);

        return self::storeFromBinary($binary, $extension);
    }

    public static function persistContentDataUrls(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $normalized = preg_replace_callback(
            '#\bsrc=(["\'])(data:image/[^"\']+)\1#i',
            function (array $matches) {
                $url = self::persistIfDataUrl($matches[2]);

                return 'src='.$matches[1].($url ?: $matches[2]).$matches[1];
            },
            $html
        );

        return self::normalizeContent($normalized ?? $html);
    }

    public static function normalizeUrl(?string $url): string
    {
        if (! $url) {
            return '';
        }

        if (preg_match('#^https?://#i', $url)) {
            return $url;
        }

        if (str_starts_with($url, '/uploads/posts/')) {
            return $url;
        }

        if (str_starts_with($url, '/storage/posts/')) {
            $basename = basename($url);
            $publicFile = public_path('uploads/posts/'.$basename);

            if (is_file($publicFile)) {
                return '/uploads/posts/'.$basename;
            }

            $legacyFile = storage_path('app/public/posts/'.$basename);
            if (is_file($legacyFile)) {
                if (! is_dir(self::directory())) {
                    mkdir(self::directory(), 0775, true);
                }
                copy($legacyFile, $publicFile);

                return '/uploads/posts/'.$basename;
            }
        }

        return $url;
    }

    public static function normalizeContent(?string $html): string
    {
        if (! $html) {
            return '';
        }

        $normalized = preg_replace_callback(
            '#\bsrc=(["\'])([^"\']+)\1#i',
            function (array $matches) {
                return 'src='.$matches[1].self::normalizeUrl($matches[2]).$matches[1];
            },
            $html
        );

        return $normalized ?? $html;
    }
}
