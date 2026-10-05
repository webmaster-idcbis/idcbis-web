<?php

/**
 * Página de un proyecto del grupo de Neurociencias.
 * El bosquejo solo entrega el nombre de la línea: el desarrollo se publica en este espacio.
 */
function investigacionNeurocienciasProyecto(array $project): array
{
    $prefix = $project['prefix'];
    $title = $project['title'];
    $image = $project['image'];

    return [
        [
            'id' => $prefix.'_hero',
            'type' => 'carousel',
            'height' => '520px',
            'slides' => [
                [
                    'id' => $prefix.'_s1',
                    'link' => null,
                    'image' => $image,
                    'title' => $title,
                    'overlay' => 'linear-gradient(90deg, rgba(0, 60, 95, 0.92) 0%, rgba(0, 86, 116, 0.78) 55%, rgba(0, 60, 95, 0.4) 100%)',
                    'buttonUrl' => '#desarrollo',
                    'buttonText' => 'Leer el desarrollo',
                    'description' => 'Proyecto en desarrollo del grupo de Neurociencias, Unidad de Terapias Avanzadas.',
                ],
            ],
            'content' => null,
            'overlay' => 'linear-gradient(90deg, rgba(0, 60, 95, 0.92) 0%, rgba(0, 86, 116, 0.78) 55%, rgba(0, 60, 95, 0.4) 100%)',
            'variant' => 'hero-full',
            'autoPlay' => false,
            'buttonBg' => '#C4A140',
            'buttonColor' => '#003C5F',
            'fullBleed' => true,
            'textAlign' => 'left',
            'showArrows' => false,
            'borderRadius' => '0px',
            'verticalAlign' => 'center',
            'showIndicators' => false,
        ],
        [
            'id' => 'desarrollo',
            'anchorId' => 'desarrollo',
            'gap' => '20px',
            'type' => 'container',
            'border' => 'none',
            'display' => 'flex',
            'padding' => '5rem 1.5rem',
            'children' => [
                [
                    'id' => $prefix.'_h',
                    'type' => 'heading',
                    'level' => 'h2',
                    'content' => $title,
                    'variant' => 'section',
                ],
                [
                    'id' => $prefix.'_p',
                    'type' => 'text',
                    'color' => '#1a1a1a',
                    'content' => 'Línea del grupo de Neurociencias de la Unidad de Terapias Avanzadas del IDCBIS. El bosquejo nombra este proyecto; su desarrollo se carga en este espacio.',
                    'fontSize' => '1.35rem',
                    'lineHeight' => '1.7',
                    'textAlign' => 'center',
                ],
            ],
            'maxWidth' => '820px',
            'minHeight' => 'auto',
            'fullBleed' => false,
            'flexDirection' => 'column',
            'alignItems' => 'stretch',
            'borderRadius' => '0px',
            'backgroundColor' => '#ffffff',
        ],
        [
            'id' => $prefix.'_cta',
            'type' => 'cta-banner',
            'title' => 'Neurociencias',
            'buttons' => [
                [
                    'id' => $prefix.'_back',
                    'url' => '/investigacion-neurociencias',
                    'icon' => '←',
                    'label' => 'Volver a Neurociencias',
                    'variant' => 'primary',
                ],
                [
                    'id' => $prefix.'_proyectos',
                    'url' => '/investigacion-neurociencias#lineas',
                    'icon' => '↓',
                    'label' => 'Ver los demás proyectos',
                    'variant' => 'outline',
                ],
            ],
            'subtitle' => 'Regrese al grupo o recorra las otras líneas.',
            'fullBleed' => true,
            'blockLabel' => 'Llamado a la acción',
            'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
        ],
    ];
}
