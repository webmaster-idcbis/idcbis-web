<?php

/**
 * Contenido de /informacion-tributaria-entidades-territoriales tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'tributaria_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Información tributaria en entidades territoriales locales',
        'content' => '',
        'subtitle' => 'Información sobre obligaciones tributarias territoriales asociadas al IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'tributaria_texto',
        'type' => 'text',
        'color' => '#334155',
        'margin' => '2rem auto',
        'content' => 'El Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud no genera información tributaria asociada al Impuesto de Industria y Comercio (ICA). En el siguiente enlace puede acceder a la página de la Secretaría Distrital de Hacienda, entidad encargada del recaudo eficiente y distribución efectiva de recursos para la implementación de políticas y proyectos en la ciudad de Bogotá.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '800px',
        'fullBleed' => false,
        'textAlign' => 'left',
        'blockLabel' => 'Contenido',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'tributaria_cta',
        'type' => 'cta-banner',
        'title' => 'Secretaría Distrital de Hacienda',
        'buttons' => [
            [
                'id' => 'tributaria_cta_shd',
                'url' => 'https://www.haciendabogota.gov.co/es/transparencia/recaudo',
                'icon' => '/img/Iconos/gestion.svg',
                'label' => 'Ir a Secretaría de Hacienda',
                'variant' => 'primary',
            ],
            [
                'id' => 'tributaria_cta_rte',
                'url' => '/obligacion-reporte-informacion',
                'icon' => '/img/Iconos/transparencia.svg',
                'label' => 'Régimen Tributario Especial',
                'variant' => 'outline',
            ],
        ],
        'subtitle' => 'Consulte información tributaria distrital o los anexos del Régimen Tributario Especial del IDCBIS.',
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
    ],
];
