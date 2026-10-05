<?php

/**
 * Entrada general de una línea de la Unidad de Terapias Avanzadas.
 * El contenido de cada línea se arma en un paso posterior.
 */
function investigacionUtaLineContent(string $prefix, string $title): array
{
    return [
        [
            'id' => $prefix.'_hero',
            'type' => 'hero',
            'color' => '#ffffff',
            'title' => $title,
            'content' => '',
            'subtitle' => 'Unidad de Terapias Avanzadas',
            'fullBleed' => true,
            'minHeight' => '280px',
            'padding' => '4.5rem 1.5rem 3.5rem',
            'textAlign' => 'center',
            'blockLabel' => 'Encabezado',
            'borderRadius' => '1px',
            'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #005674 55%, #008996 100%)',
            'backgroundImage' => '',
        ],
        [
            'id' => $prefix.'_intro',
            'gap' => '16px',
            'type' => 'container',
            'border' => 'none',
            'display' => 'flex',
            'padding' => '4.5rem 2rem',
            'children' => [
                [
                    'id' => $prefix.'_intro_h',
                    'type' => 'heading',
                    'level' => 'h2',
                    'content' => $title,
                    'variant' => 'section',
                ],
                [
                    'id' => $prefix.'_intro_p',
                    'type' => 'text',
                    'color' => '#1a1a1a',
                    'content' => 'Línea de investigación de la Unidad de Terapias Avanzadas del IDCBIS.',
                    'fontSize' => '1.125rem',
                    'textAlign' => 'center',
                ],
            ],
            'maxWidth' => '860px',
            'fullBleed' => true,
            'flexDirection' => 'column',
            'backgroundColor' => '#ffffff',
        ],
        [
            'id' => $prefix.'_cta',
            'type' => 'cta-banner',
            'title' => 'Unidad de Terapias Avanzadas',
            'buttons' => [
                [
                    'id' => $prefix.'_cta_back',
                    'url' => '/investigacion-terapias-avanzadas',
                    'icon' => '←',
                    'label' => 'Volver a la unidad',
                    'variant' => 'primary',
                ],
            ],
            'subtitle' => 'Regrese a las líneas de la unidad.',
            'fullBleed' => true,
            'blockLabel' => 'Llamado a la acción',
            'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
        ],
    ];
}
