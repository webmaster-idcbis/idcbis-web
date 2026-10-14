<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-bloques.php';

/**
 * Página de una línea: descripción completa y galería de proyectos.
 */
function investigacionIngenieriaTisularLinea(array $line): array
{
    $prefix = $line['prefix'];
    $title = $line['title'];
    $image = ingenieriaTisularImagen();

    return [
        ingenieriaTisularHero(
            $prefix.'_hero',
            $title,
            'Ingeniería de tejidos. '.$line['summary'],
            'Ver los proyectos',
            '#proyectos'
        ),
        [
            'id' => $prefix.'_intro',
            'type' => 'idcbis-about',
            'anchorId' => 'linea',
            'fullBleed' => true,
            'blockLabel' => 'Descripción de la línea',
            'title' => $title,
            'leaderLabel' => 'Unidad de Ingeniería Tisular',
            'leaderName' => $title,
            'leaderContact' => 'Línea de investigación',
            'contentSize' => '1.125rem',
            'image' => $image,
            'imageAlt' => 'Espacio reservado para la fotografía del laboratorio o de la línea de '.$title.'.',
            'buttonText' => 'Ver los proyectos',
            'buttonUrl' => '#proyectos',
            'content' => $line['content'],
        ],
        [
            'id' => $prefix.'_proyectos',
            'type' => 'idcbis-services',
            'variant' => 'plain',
            'sectionAnchor' => 'proyectos',
            'fullBleed' => true,
            'blockLabel' => 'Proyectos de la línea',
            'sectionTitle' => 'Proyectos de',
            'sectionHighlight' => $title,
            'sectionSubtitle' => 'Elija un proyecto para abrir su ficha. La fotografía de cada tarjeta está pendiente.',
            'cards' => $line['cards'],
        ],
        ingenieriaTisularCta(
            $prefix.'_cta',
            'Ingeniería de tejidos',
            'Regrese a las líneas o a la Unidad de Terapias Avanzadas.',
            [
                [
                    'id' => $prefix.'_back',
                    'url' => '/investigacion-ingenieria-tisular',
                    'icon' => '←',
                    'label' => 'Volver a Ingeniería de tejidos',
                    'variant' => 'primary',
                ],
                [
                    'id' => $prefix.'_uta',
                    'url' => '/investigacion-terapias-avanzadas',
                    'icon' => '←',
                    'label' => 'Volver a la unidad',
                    'variant' => 'outline',
                ],
            ]
        ),
    ];
}
