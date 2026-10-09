<?php

/**
 * Página de un proyecto del grupo de Inmunoterapias.
 * Misma estructura que los proyectos de Neurociencias: hero, desarrollo y regreso.
 */
function investigacionInmunoterapiaProyecto(array $project): array
{
    $prefix = $project['prefix'];
    $title = $project['title'];
    $image = $project['image'];
    $imageAlt = $project['imageAlt'] ?? $title;
    $summary = $project['summary'];
    $content = $project['content'];

    $blocks = [
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
                    'description' => $summary,
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
            'id' => $prefix.'_desarrollo',
            'type' => 'idcbis-about',
            'variant' => 'clean',
            'anchorId' => 'desarrollo',
            'fullBleed' => true,
            'blockLabel' => 'Desarrollo',
            'title' => $title,
            'contentSize' => '1.2rem',
            'image' => $image,
            'imageAlt' => $imageAlt,
            'content' => $content,
        ],
    ];

    foreach ($project['after'] ?? [] as $block) {
        $blocks[] = $block;
    }

    $blocks[] = [
        'id' => $prefix.'_cta',
        'type' => 'cta-banner',
        'title' => 'Inmunoterapias',
        'buttons' => [
            [
                'id' => $prefix.'_back',
                'url' => '/investigacion-inmunoterapia',
                'icon' => '←',
                'label' => 'Volver a Inmunoterapias',
                'variant' => 'primary',
            ],
            [
                'id' => $prefix.'_proyectos',
                'url' => '/investigacion-inmunoterapia#proyectos',
                'icon' => '↓',
                'label' => 'Ver los demás proyectos',
                'variant' => 'outline',
            ],
        ],
        'subtitle' => 'Regrese al grupo o recorra los otros proyectos.',
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
        'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
    ];

    return $blocks;
}
