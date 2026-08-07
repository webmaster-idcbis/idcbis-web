<?php

/**
 * Contenido de /programa-transparencia-etica-publica tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'pte_page_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Programa de Transparencia y Ética Pública',
        'content' => '',
        'fontSize' => '16px',
        'subtitle' => 'Transparencia
Consulta informes, seguimientos y documentos del programa de transparencia del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'pte_page_intro',
        'type' => 'text',
        'color' => '#4b5563',
        'margin' => '2rem auto',
        'content' => 'Accede a los documentos publicados por año. Cada archivo incluye la fecha de publicación oficial.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '720px',
        'fullBleed' => false,
        'textAlign' => 'center',
        'blockLabel' => 'Introducción',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'pte_page_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'pte-2026',
                'label' => '2026',
                'documents' => [
                    [
                        'id' => 'pte-2026-01',
                        'url' => '',
                        'title' => 'Mapa de riesgos corrupción I trimestre 2026',
                        'publishedAt' => '25 Mayo 2026',
                    ],
                    [
                        'id' => 'pte-2026-02',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2026',
                        'publishedAt' => '25 Mayo 2026',
                    ],
                    [
                        'id' => 'pte-2026-03',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2026 – Matriz de riesgo',
                        'publishedAt' => '25 Mayo 2026',
                    ],
                ],
            ],
            [
                'id' => 'pte-2025',
                'label' => '2025',
                'documents' => [
                    [
                        'id' => 'pte-2025-01',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2026 III cuatrimestre',
                        'publishedAt' => '10 Marzo 2026',
                    ],
                    [
                        'id' => 'pte-2025-02',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2025 II cuatrimestre',
                        'publishedAt' => '30 Enero 2026',
                    ],
                    [
                        'id' => 'pte-2025-03',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2025 I cuatrimestre',
                        'publishedAt' => '30 Enero 2026',
                    ],
                    [
                        'id' => 'pte-2025-04',
                        'url' => '',
                        'title' => 'Programa de Transparencia y Ética Pública',
                        'publishedAt' => '30 Enero 2025',
                    ],
                    [
                        'id' => 'pte-2025-05',
                        'url' => '',
                        'title' => 'Actividades de componente Transversal',
                        'publishedAt' => '30 Enero 2025',
                    ],
                    [
                        'id' => 'pte-2025-06',
                        'url' => '',
                        'title' => 'Actividades de componente programático',
                        'publishedAt' => '30 Enero 2025',
                    ],
                ],
            ],
            [
                'id' => 'pte-2024',
                'label' => '2024',
                'documents' => [
                    [
                        'id' => 'pte-2024-01',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2024 III Cuatrimestre',
                        'publishedAt' => '13 Enero 2025',
                    ],
                    [
                        'id' => 'pte-2024-02',
                        'url' => '',
                        'title' => 'Programa de Transparencia y Ética Pública V2',
                        'publishedAt' => '30 Diciembre 2024',
                    ],
                    [
                        'id' => 'pte-2024-03',
                        'url' => '',
                        'title' => 'Programa Transparencia y Ética Pública 2024 II Cuatrimestre',
                        'publishedAt' => '10 Septiembre 2024',
                    ],
                    [
                        'id' => 'pte-2024-04',
                        'url' => '',
                        'title' => 'Programa de Transparencia y Ética Pública 2024',
                        'publishedAt' => '30 Enero 2024',
                    ],
                    [
                        'id' => 'pte-2024-05',
                        'url' => '',
                        'title' => 'Declaración Cumplimiento Normativo',
                        'publishedAt' => '26 Abril 2024',
                    ],
                    [
                        'id' => 'pte-2024-06',
                        'url' => '',
                        'title' => 'Declaración Cumplimiento Normativo (2)',
                        'publishedAt' => '26 Abril 2024',
                    ],
                    [
                        'id' => 'pte-2024-07',
                        'url' => '',
                        'title' => 'Declaración Cumplimiento Normativo Javeriana',
                        'publishedAt' => '29 Abril 2024',
                    ],
                    [
                        'id' => 'pte-2024-08',
                        'url' => '',
                        'title' => 'Seguimiento al Programa de Transparencia y Ética Pública I Cuatrimestre',
                        'publishedAt' => '16 Mayo 2024',
                    ],
                    [
                        'id' => 'pte-2024-09',
                        'url' => '',
                        'title' => 'Declaración de conocimiento y aceptación de la política de cumplimiento normativo',
                        'publishedAt' => '17 Junio 2024',
                    ],
                    [
                        'id' => 'pte-2024-10',
                        'url' => '',
                        'title' => 'Declaración cumplimiento Centro Oriente',
                        'publishedAt' => '09 Agosto 2024',
                    ],
                    [
                        'id' => 'pte-2024-11',
                        'url' => '',
                        'title' => 'Declaración cumplimiento Subred Sur',
                        'publishedAt' => '09 Agosto 2024',
                    ],
                    [
                        'id' => 'pte-2024-12',
                        'url' => '',
                        'title' => 'Declaración cumplimiento Unal',
                        'publishedAt' => '09 Agosto 2024',
                    ],
                ],
            ],
            [
                'id' => 'pte-2023',
                'label' => '2023',
                'documents' => [
                    [
                        'id' => 'pte-2023-01',
                        'url' => '',
                        'title' => 'Programa de Transparencia y Ética Pública',
                        'publishedAt' => '27 Enero 2023',
                    ],
                    [
                        'id' => 'pte-2023-02',
                        'url' => '',
                        'title' => 'Programa de Transparencia y Ética Pública V2',
                        'publishedAt' => '10 Julio 2023',
                    ],
                    [
                        'id' => 'pte-2023-03',
                        'url' => '',
                        'title' => 'Seguimiento I Cuatrimestre 2023',
                        'publishedAt' => '15 Mayo 2023',
                    ],
                    [
                        'id' => 'pte-2023-04',
                        'url' => '',
                        'title' => 'Seguimiento II Cuatrimestre 2023',
                        'publishedAt' => '13 Septiembre 2023',
                    ],
                    [
                        'id' => 'pte-2023-05',
                        'url' => '',
                        'title' => 'Seguimiento III Cuatrimestre 2023',
                        'publishedAt' => '16 Enero 2024',
                    ],
                ],
            ],
        ],
        'layout' => 'sidebar',
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Listado de documentos',
        'showSearch' => true,
        'documentColumns' => 2,
    ],
];
