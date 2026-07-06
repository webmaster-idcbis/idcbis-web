<?php

/**
 * Bloque idcbis-documents-page — Rendición de Cuentas.
 * Fuente: https://idcbis.org.co/rendicion-de-cuentas/
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt = '',
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

$informeYPresentacion = static function (
    string $prefix,
    string $informeTitle,
    string $presentacionTitle,
) use ($doc): array {
    return [
        $doc("{$prefix}-inf", $informeTitle),
        $doc("{$prefix}-pre", $presentacionTitle),
    ];
};

return [
    'id' => 'rc_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Rendición de Cuentas',
    'heroSubtitle' => 'Consulta informes, presentaciones y documentos de rendición de cuentas del IDCBIS.',
    'intro' => 'Selecciona un año en el menú lateral para ver los documentos publicados. Los enlaces a videos se pueden agregar cuando estén disponibles.',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
    'groups' => [
        [
            'id' => 'rc-2025',
            'label' => '2025',
            'documents' => [
                $doc('rc-cs-01', 'Informes de control social IDCBIS'),
                $doc('rc-cs-02', 'Rendición de cuentas Sistema General de Regalías 2025'),
            ],
        ],
        [
            'id' => 'rc-2024',
            'label' => '2024',
            'documents' => [
                $doc('rc-2024-4t-inf', 'Informe de Gestión Rendición de Cuentas 4to Trimestre 2024'),
                $doc('rc-2024-4t-pre', 'Presentación Rendición de Cuentas 4to Trimestre 2024'),
                ...$informeYPresentacion(
                    'rc-2024-3t',
                    'Informe de Rendición de cuentas 3er Trimestre 2024',
                    'Presentación Rendición de cuentas 2do Trimestre 2024',
                ),
                ...$informeYPresentacion(
                    'rc-2024-2t',
                    'Informe de Rendición de cuentas 2do Trimestre 2024',
                    'Presentación Rendición de cuentas 2do Trimestre 2024',
                ),
                ...$informeYPresentacion(
                    'rc-2024-1t',
                    'Informe de Rendición de cuentas 1er Trimestre 2024',
                    'Presentación Rendición de cuentas 1er Trimestre 2024',
                ),
                $doc('rc-2024-1t-est', 'Estrategia de Rendición de Cuentas'),
            ],
        ],
        [
            'id' => 'rc-2023',
            'label' => '2023',
            'documents' => [
                ...$informeYPresentacion(
                    'rc-2023-4t',
                    'Informe de Rendición de cuentas 4to Trimestre 2023',
                    'Presentación Rendición de cuentas 4to Trimestre 2023',
                ),
                ...$informeYPresentacion(
                    'rc-2023-3t',
                    'Informe de Rendición de cuentas 3er Trimestre 2023',
                    'Presentación Rendición de cuentas 3er Trimestre 2023',
                ),
                ...$informeYPresentacion(
                    'rc-2023-2t',
                    'Informe de Rendición de cuentas 2do Trimestre 2023',
                    'Presentación Rendición de cuentas 2do Trimestre 2023',
                ),
                ...$informeYPresentacion(
                    'rc-2023-1t',
                    'Informe de Rendición de cuentas 1er Trimestre 2023',
                    'Presentación Rendición de cuentas 1er Trimestre 2023',
                ),
                $doc('rc-2023-1t-est', 'Estrategia de Rendición de Cuentas'),
            ],
        ],
        [
            'id' => 'rc-2022',
            'label' => '2022',
            'documents' => [
                ...$informeYPresentacion(
                    'rc-2022-4t',
                    'Informe de Rendición de cuentas 4to Trimestre 2022',
                    'Presentación Rendición de cuentas 4to Trimestre 2022',
                ),
                $doc('rc-2022-salud-inf', 'Informe General Rendición de cuentas 2022 (Sector Salud)'),
                ...$informeYPresentacion(
                    'rc-2022-3t',
                    'Informe de Rendición de cuentas 3er Trimestre 2022',
                    'Presentación Rendición de cuentas 3er Trimestre 2022',
                ),
                ...$informeYPresentacion(
                    'rc-2022-2t',
                    'Informe de Rendición de cuentas 2do Trimestre 2022',
                    'Presentación Rendición de cuentas 2do Trimestre 2022',
                ),
                $doc('rc-2022-1t-inf', 'Informe Rendición de cuentas 1er Trimestre 2022'),
                $doc('rc-2022-1t-pre', 'Presentación Rendición de cuentas 1er Trimestre 2022'),
            ],
        ],
        [
            'id' => 'rc-2021',
            'label' => '2021',
            'documents' => [
                $doc('rc-2021-inf', 'Informe Rendición de cuentas 2021'),
                $doc('rc-2021-res', 'Resumen Rendición de cuentas 2021'),
            ],
        ],
        [
            'id' => 'rc-2020',
            'label' => '2020',
            'documents' => [
                $doc('rc-2020-inf', 'Informe Rendición de cuentas 2020'),
                $doc('rc-2020-res', 'Resumen Rendición de cuentas 2020'),
            ],
        ],
        [
            'id' => 'rc-2019',
            'label' => '2019',
            'documents' => [
                $doc('rc-2019-inf', 'Informe Rendición de cuentas 2019'),
                $doc('rc-2019-res', 'Resumen Rendición de cuentas 2019'),
            ],
        ],
        [
            'id' => 'rc-2018',
            'label' => '2018',
            'documents' => [
                $doc('rc-2018-inf', 'Informe de gestión'),
            ],
        ],
        [
            'id' => 'rc-2017',
            'label' => '2017',
            'documents' => [
                $doc('rc-2017-inf', 'Informe de rendición de cuentas'),
                $doc('rc-2017-ava', 'Avance científico'),
            ],
        ],
        [
            'id' => 'rc-calendario',
            'label' => 'Calendario',
            'documents' => [
                $doc('rc-cal-01', 'Calendario de actividades'),
            ],
        ],
    ],
];
