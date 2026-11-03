<?php

/**
 * Contenido de /noticias (bloques del editor).
 * Las tarjetas salen de database/data/noticias-posts.php.
 */

$posts = require __DIR__.'/noticias-posts.php';
usort($posts, static fn (array $a, array $b) => strcmp($b['published_at'], $a['published_at']));

$toItem = static function (array $post): array {
    return [
        'id' => $post['id'],
        'slug' => $post['slug'],
        'image' => $post['image'],
        'title' => $post['title'],
        'excerpt' => $post['excerpt'],
        'category' => $post['category'],
        'publishedAt' => $post['published_label'],
    ];
};

$items = array_map($toItem, $posts);

return [
    [
        'id' => 'noticias_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Noticias',
        'content' => '',
        'subtitle' => 'Conoce los avances, reconocimientos y novedades del IDCBIS en ciencia, biotecnología e innovación en salud.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'noticias_list',
        'type' => 'idcbis-news-list',
        'items' => $items,
        'columns' => 3,
        'fullBleed' => true,
        'blockLabel' => 'Listado de noticias',
        'showSearch' => true,
        'itemsPerPage' => 9,
        'showCategoryFilter' => true,
    ],
    [
        'id' => 'noticias_carousel',
        'type' => 'idcbis-news-carousel',
        'items' => array_slice($items, 0, 6),
        'limit' => 8,
        'autoPlay' => true,
        'interval' => 4500,
        'fullBleed' => true,
        'blockLabel' => 'Carrusel de noticias',
        'sectionTitle' => 'Noticias destacadas',
        'sectionEyebrow' => 'Actualidad',
        'sectionSubtitle' => 'Desliza para conocer las publicaciones más recientes del IDCBIS.',
    ],
];
