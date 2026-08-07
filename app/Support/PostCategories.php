<?php

namespace App\Support;

class PostCategories
{
    /** @var array<string, string> */
    public const LABELS = [
        'apropiacion-social' => 'Apropiación Social del Conocimiento',
        'celulas' => 'Células',
        'congreso' => 'Congreso',
        'convenios' => 'Convenios',
        'donacion' => 'Donación',
        'investigacion' => 'Investigación',
        'reconocimientos' => 'Reconocimientos',
        'sangre' => 'Sangre',
        'tejidos' => 'Tejidos',
        'sin-categoria' => 'Sin categoría',
    ];

    public static function label(?string $category): string
    {
        if (! $category) {
            return self::LABELS['sin-categoria'];
        }

        return self::LABELS[$category] ?? $category;
    }

    /** @return array<int, string> */
    public static function ids(): array
    {
        return array_keys(self::LABELS);
    }

    public static function isValid(?string $category): bool
    {
        return $category !== null && array_key_exists($category, self::LABELS);
    }
}
