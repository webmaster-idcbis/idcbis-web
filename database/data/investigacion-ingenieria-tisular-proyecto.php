<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-bloques.php';

/**
 * Ficha de un proyecto: lectura por secciones, con anclas cuando hay más de un apartado.
 */
function investigacionIngenieriaTisularProyecto(array $project): array
{
    $prefix = $project['prefix'];
    $title = $project['title'];
    $sections = $project['sections'];
    $blocks = [
        ingenieriaTisularHero(
            $prefix.'_hero',
            $title,
            $project['eyebrow'].'. '.$project['summary'],
            'Leer la ficha',
            '#'.$sections[0]['anchor'],
            '520px'
        ),
    ];

    if (count($sections) > 1) {
        $blocks[] = [
            'id' => $prefix.'_nav',
            'type' => 'idcbis-anchor-nav',
            'fullBleed' => true,
            'blockLabel' => 'Navegación de la ficha',
            'label' => 'Secciones de '.$title,
            'backLabel' => 'Volver arriba',
            'links' => array_map(
                fn (array $section) => [
                    'id' => $prefix.'_nav_'.$section['anchor'],
                    'label' => $section['nav'],
                    'url' => '#'.$section['anchor'],
                ],
                $sections
            ),
        ];
    }

    foreach ($sections as $section) {
        if (($project['highlightsAnchor'] ?? null) === $section['anchor'] && ! empty($project['highlights'])) {
            $blocks[] = [
                'id' => $prefix.'_llamadas',
                'type' => 'idcbis-highlights',
                'fullBleed' => true,
                'blockLabel' => 'Llamadas',
                'sectionTitle' => 'Respaldo',
                'sectionHighlight' => 'documentado',
                'items' => $project['highlights'],
            ];
        }

        $blocks[] = [
            'id' => $prefix.'_'.$section['anchor'],
            'type' => 'idcbis-about',
            'variant' => 'clean',
            'anchorId' => $section['anchor'],
            'scrollMargin' => '120px',
            'fullBleed' => true,
            'blockLabel' => $section['nav'],
            'title' => $section['title'],
            'contentSize' => '1.125rem',
            'content' => $section['content'],
        ];
    }

    $blocks[] = ingenieriaTisularCta(
        $prefix.'_cta',
        $project['lineTitle'],
        'Regrese a los proyectos de la línea o al inicio de Ingeniería de tejidos.',
        [
            [
                'id' => $prefix.'_back',
                'url' => $project['backUrl'],
                'icon' => '←',
                'label' => $project['backLabel'],
                'variant' => 'primary',
            ],
            [
                'id' => $prefix.'_hub',
                'url' => '/investigacion-ingenieria-tisular',
                'icon' => '←',
                'label' => 'Volver a Ingeniería de tejidos',
                'variant' => 'outline',
            ],
        ]
    );

    return $blocks;
}
