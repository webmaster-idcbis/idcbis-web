<?php

/**
 * Bloque idcbis-documents-page — Ejecución presupuestal.
 * Fuente: https://idcbis.org.co/ejecucion-presupuestal/
 *
 * Generado/sincronizado desde la base de datos con page:sync-data-files
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt = '',
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

$page = [
    'id' => 'ep_page_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Ejecución presupuestal',
    'heroSubtitle' => 'Consulta los informes mensuales de ejecución presupuestal del IDCBIS, organizados por vigencia.',
    'intro' => '',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
,
    'groups' => [
        [
            'id' => 'ep-2026',
            'label' => '2026',
            'documents' => [
                $doc('ep-2026-01', 'Ejecución presupuestal – Enero', '23 Febrero 2026'),
                $doc('ep-2026-02', 'Ejecución presupuestal – Febrero', '17 Marzo 2026'),
                $doc('ep-2026-03', 'Ejecución presupuestal – Marzo', '24 Abril 2026'),
                $doc('ep-2026-04', 'Ejecución presupuestal – Abril', '03 Junio 2026'),
                $doc('ep-2026-05', 'Ejecución presupuestal – Mayo', '24 Junio 2026'),
            ],
        ],
        [
            'id' => 'ep-2025',
            'label' => '2025',
            'documents' => [
                $doc('ep-2025-01', 'Ejecución presupuestal – Enero', '13 Febrero 2025'),
                $doc('ep-2025-02', 'Ejecución presupuestal – Febrero', '15 Mayo 2025'),
                $doc('ep-2025-03', 'Ejecución presupuestal – Marzo', '15 Mayo 2025'),
                $doc('ep-2025-04', 'Ejecución presupuestal – Abril', '15 Mayo 2025'),
                $doc('ep-2025-05', 'Ejecución presupuestal – Mayo', '4 Julio 2025'),
                $doc('ep-2025-06', 'Ejecución presupuestal – Junio', '15 Julio 2025'),
                $doc('ep-2025-07', 'Ejecución presupuestal – Julio', '15 Agosto 2025'),
                $doc('ep-2025-08', 'Ejecución presupuestal – Agosto', '15 Septiembre 2025'),
                $doc('ep-2025-09', 'Ejecución presupuestal – Septiembre', '15 Octubre 2025'),
                $doc('ep-2025-10', 'Ejecución presupuestal – Octubre', '20 Noviembre 2025'),
                $doc('ep-2025-11', 'Ejecución presupuestal – Noviembre', '18 Diciembre 2025'),
                $doc('ep-2025-12', 'Ejecución presupuestal – Diciembre', '19 Enero 2026'),
            ],
        ],
        [
            'id' => 'ep-2024',
            'label' => '2024',
            'documents' => [
                $doc('ep-2024-01', 'Ejecución presupuestal – Enero', '12 Marzo 2024'),
                $doc('ep-2024-02', 'Ejecución presupuestal – Febrero', '02 Abril 2024'),
                $doc('ep-2024-03', 'Ejecución presupuestal – Marzo', '19 Abril 2024'),
                $doc('ep-2024-04', 'Ejecución presupuestal – Abril', '24 Mayo 2024'),
                $doc('ep-2024-05', 'Ejecución presupuestal – Mayo', '17 Junio 2024'),
                $doc('ep-2024-06', 'Ejecución presupuestal – Junio', '29 Julio 2024'),
                $doc('ep-2024-07', 'Ejecución presupuestal – Julio', '16 Agosto 2024'),
                $doc('ep-2024-08', 'Ejecución presupuestal – Agosto', '11 Septiembre 2024'),
                $doc('ep-2024-09', 'Ejecución presupuestal – Septiembre', '10 Octubre 2024'),
                $doc('ep-2024-10', 'Ejecución presupuestal – Octubre', '22 Noviembre 2024'),
                $doc('ep-2024-11', 'Ejecución presupuestal – Noviembre', '17 Diciembre 2024'),
                $doc('ep-2024-12', 'Ejecución presupuestal – Diciembre', '15 Enero 2025'),
            ],
        ],
        [
            'id' => 'ep-2023',
            'label' => '2023',
            'documents' => [
                $doc('ep-2023-01', 'Ejecución presupuestal – Enero', '31 Marzo 2023'),
                $doc('ep-2023-02', 'Ejecución presupuestal – Febrero', '31 Marzo 2023'),
                $doc('ep-2023-03', 'Ejecución presupuestal – Marzo', '5 Mayo 2023'),
                $doc('ep-2023-04', 'Ejecución presupuestal – Abril', '31 Mayo 2023'),
                $doc('ep-2023-05', 'Ejecución presupuestal – Mayo', '5 Julio 2023'),
                $doc('ep-2023-06', 'Ejecución presupuestal – Junio', '21 Julio 2023'),
                $doc('ep-2023-07', 'Ejecución presupuestal – Julio', '24 Agosto 2023'),
                $doc('ep-2023-08', 'Ejecución presupuestal – Agosto', '28 Septiembre 2023'),
                $doc('ep-2023-09', 'Ejecución presupuestal – Septiembre', '17 Octubre 2023'),
                $doc('ep-2023-10', 'Ejecución presupuestal – Octubre', '06 Diciembre 2023'),
                $doc('ep-2023-11', 'Ejecución presupuestal – Noviembre', '11 Enero 2024'),
                $doc('ep-2023-12', 'Ejecución presupuestal – Diciembre', '24 Enero 2024'),
            ],
        ],
        [
            'id' => 'ep-2022',
            'label' => '2022',
            'documents' => [
                $doc('ep-2022-01', 'Ejecución presupuestal – Enero', '23 Mayo 2022'),
                $doc('ep-2022-02', 'Ejecución presupuestal – Febrero', '23 Mayo 2022'),
                $doc('ep-2022-03', 'Ejecución presupuestal – Marzo', '23 Mayo 2022'),
                $doc('ep-2022-04', 'Ejecución presupuestal – Abril', '23 Mayo 2022'),
                $doc('ep-2022-05', 'Ejecución presupuestal – Mayo', '14 Julio 2022'),
                $doc('ep-2022-06', 'Ejecución presupuestal – Junio', '14 Julio 2022'),
                $doc('ep-2022-07', 'Ejecución presupuestal – Julio', '16 Agosto 2022'),
                $doc('ep-2022-08', 'Ejecución presupuestal – Agosto', '19 Septiembre 2022'),
                $doc('ep-2022-09', 'Ejecución presupuestal – Septiembre', '16 Enero 2023'),
                $doc('ep-2022-10', 'Ejecución presupuestal – Octubre', '16 Enero 2023'),
                $doc('ep-2022-11', 'Ejecución presupuestal – Noviembre', '16 Enero 2023'),
                $doc('ep-2022-12', 'Ejecución presupuestal – Diciembre', '16 Enero 2023'),
            ],
        ],
        [
            'id' => 'ep-2021',
            'label' => '2021',
            'documents' => [
            ],
        ],
        [
            'id' => 'ep-2020',
            'label' => '2020',
            'documents' => [
            ],
        ],
        [
            'id' => 'ep-2019',
            'label' => '2019',
            'documents' => [
            ],
        ],
        [
            'id' => 'ep-2018',
            'label' => '2018',
            'documents' => [
            ],
        ],
    ],
];

return $page;
