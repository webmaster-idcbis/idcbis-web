<?php

/**
 * Contenido de /mapa-del-sitio tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'sitemap_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Mapa del sitio',
        'content' => '',
        'subtitle' => 'Encuentra rápidamente cualquier sección del sitio web del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
    ],
    [
        'id' => 'sitemap_block',
        'type' => 'sitemap',
        'content' => '',
        'showHero' => false,
        'showNote' => true,
        'fullBleed' => true,
        'blockLabel' => 'Índice de páginas',
    ],
];
