<?php

/**
 * Mapa del sitio — hero + grid de enlaces en bloques separados.
 */
return [
    [
        'id' => 'sitemap_hero',
        'type' => 'hero',
        'blockLabel' => 'Encabezado',
        'content' => '',
        'fullBleed' => true,
        'title' => 'Mapa del sitio',
        'subtitle' => 'Encuentra rápidamente cualquier sección del sitio web del IDCBIS.',
        'minHeight' => '260px',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'textAlign' => 'center',
        'color' => '#ffffff',
    ],
    [
        'id' => 'sitemap_block',
        'type' => 'sitemap',
        'blockLabel' => 'Índice de páginas',
        'content' => '',
        'fullBleed' => true,
        'showHero' => false,
        'showNote' => true,
    ],
];
