<?php

/**
 * Contenido de /datos-abiertos tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'datos_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Datos Abiertos',
        'content' => '',
        'subtitle' => 'Consulte los datos abiertos del IDCBIS y los instrumentos de gestión de la información.',
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'datos_links',
        'type' => 'idcbis-links',
        'color' => '#0b4f6c',
        'links' => [
            [
                'id' => 'datos_link_portal',
                'url' => 'https://datosabiertos.bogota.gov.co/organization/instituto-distrital-de-ciencia-biotecnologia-e-innovacion-en-salud-idcbis',
                'icon' => '/img/Iconos/transparencia.svg',
                'label' => 'Datos Abiertos IDCBIS',
                'description' => 'Datos Abiertos del IDCBIS publicados en datosabiertos.bogota.gov.co.',
            ],
            [
                'id' => 'datos_link_pinar',
                'url' => 'https://idcbis.org.co/documentos/datos/Plan_Institucional_de_Archivos.pdf',
                'icon' => '/img/Iconos/gestion.svg',
                'label' => 'Plan Institucional de Archivos - PINAR',
                'description' => 'Instrumento de planeación archivística institucional.',
            ],
            [
                'id' => 'datos_link_esquema',
                'url' => 'https://idcbis.org.co/pdf/IDCBIS_Esquema_Publicaci%C3%B3n.pdf',
                'icon' => '/img/Iconos/politicas y lineamientos.svg',
                'label' => 'Esquema de Publicación de la Información',
                'description' => 'Esquema de publicación de información pública.',
            ],
            [
                'id' => 'datos_link_pgd',
                'url' => 'https://idcbis.org.co/pdf/Programa_gestion_documental_v2.pdf',
                'icon' => '/img/Iconos/gestion.svg',
                'label' => 'Programa Gestión Documental (PGD)',
                'description' => 'Programa de gestión documental del instituto.',
            ],
            [
                'id' => 'datos_link_sic',
                'url' => 'https://idcbis.org.co/pdf/Plan_de_Conservacion_Documental_VF.pdf',
                'icon' => '/img/Iconos/etica.svg',
                'label' => 'Sistema Integrado de Conservación (SIC)',
                'description' => 'Plan de Conservación Documental 2024.',
            ],
        ],
        'fullBleed' => true,
        'blockLabel' => 'Datos e instrumentos',
        'cardBorder' => 'none',
        'sectionTitle' => 'Datos e',
        'cardBoxShadow' => '0 8px 30px rgba(11, 79, 108, 0.08)',
        'cardTextColor' => '#475569',
        'cardBackground' => '#ffffff',
        'cardTitleColor' => '#0b4f6c',
        'highlightColor' => '#2c8c99',
        'backgroundColor' => '#f0f5f8',
        'sectionSubtitle' => 'Acceda al portal de datos abiertos y a los instrumentos de gestión documental.',
        'cardBorderRadius' => '20px',
        'sectionHighlight' => 'instrumentos',
    ],
];
