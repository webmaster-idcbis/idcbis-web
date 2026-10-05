<?php

/**
 * Sección general de /investigacion-terapias-avanzadas.
 * Las cuatro líneas se desarrollan en páginas propias.
 * layout expand: al pasar el cursor una tarjeta crece y muestra su texto.
 */

return [
    [
        'id' => 'uta_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Unidad de Terapias Avanzadas',
        'content' => '',
        'subtitle' => 'Cuatro líneas de investigación en terapia celular, génica e ingeniería de tejidos.',
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
        'id' => 'uta_lineas',
        'type' => 'idcbis-links',
        'layout' => 'expand',
        'color' => '#0B4F6C',
        'links' => [
            [
                'id' => 'uta_l1',
                'url' => '/investigacion-neurociencias',
                'icon' => '🧠',
                'label' => 'Neurociencias',
                'description' => 'Estudia enfermedades neurodegenerativas y cómo la terapia celular interactúa con el trauma raquimedular.',
            ],
            [
                'id' => 'uta_l2',
                'url' => '/investigacion-ingenieria-tisular',
                'icon' => '🦴',
                'label' => 'Ingeniería tisular',
                'description' => 'Regenera piel y hueso con andamios biológicos, impresión 3D y células encapsuladas.',
            ],
            [
                'id' => 'uta_l3',
                'url' => '/investigacion-innovacion-produccion',
                'icon' => '🏭',
                'label' => 'Innovación y producción',
                'description' => 'Lleva productos celulares a escala y estudia esferoides, vesículas extracelulares y cuerpos apoptóticos.',
            ],
            [
                'id' => 'uta_l4',
                'url' => '/investigacion-inmunoterapia',
                'icon' => '🛡️',
                'label' => 'Inmunoterapia',
                'description' => 'Desarrolla células CAR-T, inmunoterapia génica y modelos de enfermedad con CRISPR-Cas9.',
            ],
        ],
        'fullBleed' => true,
        'blockLabel' => 'Líneas',
        'cardBorder' => '1px solid rgba(11, 79, 108, 0.14)',
        'sectionTitle' => 'Líneas de',
        'cardTextColor' => '#1a1a1a',
        'cardBackground' => '#ffffff',
        'cardTitleColor' => '#0B4F6C',
        'highlightColor' => '#008996',
        'backgroundColor' => '#f8f9fa',
        'sectionSubtitle' => 'Pase el cursor para leer cada línea y elija una para continuar.',
        'cardBorderRadius' => '20px',
        'sectionHighlight' => 'investigación',
    ],
    [
        'id' => 'uta_cta',
        'type' => 'cta-banner',
        'title' => 'Investigación IDCBIS',
        'buttons' => [
            [
                'id' => 'uta_cta_inv',
                'url' => '/investigacion',
                'icon' => '←',
                'label' => 'Volver a investigación',
                'variant' => 'primary',
            ],
        ],
        'subtitle' => 'Regrese al conjunto de líneas del instituto.',
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
        'backgroundColor' => 'linear-gradient(135deg, #005674 0%, #008996 100%)',
    ],
];
