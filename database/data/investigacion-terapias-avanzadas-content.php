<?php

/**
 * Sección general de /investigacion-terapias-avanzadas.
 * Las cuatro líneas se desarrollan en páginas propias.
 * layout media: cada línea muestra su imagen y el texto, sin ocultar la descripción.
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
        'layout' => 'media',
        'color' => '#0B4F6C',
        'links' => [
            [
                'id' => 'uta_l1',
                'url' => '/investigacion-neurociencias',
                'icon' => '🧠',
                'image' => '/img/neurociencias/hero.jpg',
                'imageAlt' => 'Neurona vista al microscopio.',
                'label' => 'Neurociencias',
                'description' => 'Estudia enfermedades neurodegenerativas y cómo la terapia celular interactúa con el trauma raquimedular.',
            ],
            [
                'id' => 'uta_l2',
                'url' => '/investigacion-ingenieria-tisular',
                'icon' => '🦴',
                'image' => '/img/Servicios%20Home/BT-1200x800.png',
                'imageAlt' => 'Fragmento de tejido sostenido con pinzas.',
                'label' => 'Ingeniería tisular',
                'description' => 'Regenera piel y hueso con andamios biológicos, impresión 3D y células encapsuladas.',
            ],
            [
                'id' => 'uta_l3',
                'url' => '/investigacion-innovacion-produccion',
                'icon' => '🏭',
                'image' => '/img/Servicios%20Home/TE-AV-1200x800.png',
                'imageAlt' => 'Objetivos de un microscopio de laboratorio.',
                'label' => 'Innovación y producción',
                'description' => 'Lleva productos celulares a escala y estudia esferoides, vesículas extracelulares y cuerpos apoptóticos.',
            ],
            [
                'id' => 'uta_l4',
                'url' => '/investigacion-inmunoterapia',
                'icon' => '🛡️',
                'image' => '/img/programa%203.png',
                'imageAlt' => 'Células observadas por microscopía de fluorescencia.',
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
        'sectionSubtitle' => 'Elija una línea para conocer su trabajo.',
        'cardBorderRadius' => '20px',
        'sectionHighlight' => 'investigación',
    ],
];
