<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponsiveImageController extends Controller
{
    private const WIDTHS = [400, 768, 800, 1280, 1920];

    public function show(string $path): BinaryFileResponse|Response
    {
        if (! preg_match('/^(?<base>.+)-(?<width>\d+)w\.webp$/', $path, $matches)) {
            abort(404);
        }

        $width = (int) $matches['width'];
        if (! in_array($width, self::WIDTHS, true)) {
            abort(404);
        }

        $imgRoot = realpath(public_path('img'));
        if ($imgRoot === false) {
            abort(404);
        }

        $relativeDir = dirname($matches['base']);
        $directory = realpath(public_path('img/'.$relativeDir));
        if ($directory === false || ! str_starts_with($directory, $imgRoot)) {
            abort(404);
        }

        $name = basename($matches['base']);
        $source = $this->findSource($directory, $name);
        if ($source === null || ! function_exists('imagewebp')) {
            abort(404);
        }

        $target = $directory.DIRECTORY_SEPARATOR.$name.'-'.$width.'w.webp';
        if (! is_file($target)) {
            $this->writeVariant($source, $target, $width);
        }

        if (! is_file($target)) {
            abort(404);
        }

        return response()->file($target, [
            'Content-Type' => 'image/webp',
            'Cache-Control' => 'public, max-age=2592000',
        ]);
    }

    private function findSource(string $directory, string $name): ?string
    {
        foreach (['jpg', 'jpeg', 'png', 'webp'] as $extension) {
            $candidate = $directory.DIRECTORY_SEPARATOR.$name.'.'.$extension;
            if (is_file($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    private function writeVariant(string $source, string $target, int $width): void
    {
        $image = $this->loadImage($source);
        if ($image === null) {
            return;
        }

        $sourceWidth = imagesx($image);
        $sourceHeight = imagesy($image);
        $targetWidth = min($width, $sourceWidth);
        $targetHeight = (int) max(1, round($sourceHeight * ($targetWidth / $sourceWidth)));

        $resized = imagescale($image, $targetWidth, $targetHeight, IMG_BICUBIC);
        imagedestroy($image);

        if ($resized === false) {
            return;
        }

        imagepalettetotruecolor($resized);
        imagewebp($resized, $target, 80);
        imagedestroy($resized);
    }

    private function loadImage(string $source): ?\GdImage
    {
        $extension = strtolower(pathinfo($source, PATHINFO_EXTENSION));

        $image = match ($extension) {
            'jpg', 'jpeg' => @imagecreatefromjpeg($source),
            'png' => @imagecreatefrompng($source),
            'webp' => function_exists('imagecreatefromwebp') ? @imagecreatefromwebp($source) : false,
            default => false,
        };

        return $image instanceof \GdImage ? $image : null;
    }
}
