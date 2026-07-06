<?php

/**
 * Bloque idcbis-documents-page — Ejecución presupuestal.
 * Fuente: https://idcbis.org.co/ejecucion-presupuestal/
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt = '',
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

$monthNames = [
    1 => 'Enero',
    2 => 'Febrero',
    3 => 'Marzo',
    4 => 'Abril',
    5 => 'Mayo',
    6 => 'Junio',
    7 => 'Julio',
    8 => 'Agosto',
    9 => 'Septiembre',
    10 => 'Octubre',
    11 => 'Noviembre',
    12 => 'Diciembre',
];

$monthlyDocs = static function (int $year, array $publishedByMonth) use ($doc, $monthNames): array {
    $documents = [];

    foreach ($publishedByMonth as $month => $publishedAt) {
        $monthKey = str_pad((string) $month, 2, '0', STR_PAD_LEFT);
        $documents[] = $doc(
            "ep-{$year}-{$monthKey}",
            'Ejecución presupuestal – '.$monthNames[$month],
            $publishedAt,
        );
    }

    return $documents;
};

return [
    'id' => 'ep_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Ejecución presupuestal',
    'heroSubtitle' => 'Consulta los informes mensuales de ejecución presupuestal del IDCBIS, organizados por vigencia.',
    'intro' => 'Selecciona un año en el menú lateral para ver los informes publicados. Cada documento incluye su fecha de publicación oficial cuando está disponible.',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
    'groups' => [
        [
            'id' => 'ep-2026',
            'label' => '2026',
            'documents' => $monthlyDocs(2026, [
                1 => '23 Febrero 2026',
                2 => '17 Marzo 2026',
                3 => '24 Abril 2026',
                4 => '03 Junio 2026',
                5 => '24 Junio 2026',
            ]),
        ],
        [
            'id' => 'ep-2025',
            'label' => '2025',
            'documents' => $monthlyDocs(2025, [
                1 => '13 Febrero 2025',
                2 => '15 Mayo 2025',
                3 => '15 Mayo 2025',
                4 => '15 Mayo 2025',
                5 => '4 Julio 2025',
                6 => '15 Julio 2025',
                7 => '15 Agosto 2025',
                8 => '15 Septiembre 2025',
                9 => '15 Octubre 2025',
                10 => '20 Noviembre 2025',
                11 => '18 Diciembre 2025',
                12 => '19 Enero 2026',
            ]),
        ],
        [
            'id' => 'ep-2024',
            'label' => '2024',
            'documents' => $monthlyDocs(2024, [
                1 => '12 Marzo 2024',
                2 => '02 Abril 2024',
                3 => '19 Abril 2024',
                4 => '24 Mayo 2024',
                5 => '17 Junio 2024',
                6 => '29 Julio 2024',
                7 => '16 Agosto 2024',
                8 => '11 Septiembre 2024',
                9 => '10 Octubre 2024',
                10 => '22 Noviembre 2024',
                11 => '17 Diciembre 2024',
                12 => '15 Enero 2025',
            ]),
        ],
        [
            'id' => 'ep-2023',
            'label' => '2023',
            'documents' => $monthlyDocs(2023, [
                1 => '31 Marzo 2023',
                2 => '31 Marzo 2023',
                3 => '5 Mayo 2023',
                4 => '31 Mayo 2023',
                5 => '5 Julio 2023',
                6 => '21 Julio 2023',
                7 => '24 Agosto 2023',
                8 => '28 Septiembre 2023',
                9 => '17 Octubre 2023',
                10 => '06 Diciembre 2023',
                11 => '11 Enero 2024',
                12 => '24 Enero 2024',
            ]),
        ],
        [
            'id' => 'ep-2022',
            'label' => '2022',
            'documents' => $monthlyDocs(2022, [
                1 => '23 Mayo 2022',
                2 => '23 Mayo 2022',
                3 => '23 Mayo 2022',
                4 => '23 Mayo 2022',
                5 => '14 Julio 2022',
                6 => '14 Julio 2022',
                7 => '16 Agosto 2022',
                8 => '19 Septiembre 2022',
                9 => '16 Enero 2023',
                10 => '16 Enero 2023',
                11 => '16 Enero 2023',
                12 => '16 Enero 2023',
            ]),
        ],
        [
            'id' => 'ep-2021',
            'label' => '2021',
            'documents' => [],
        ],
        [
            'id' => 'ep-2020',
            'label' => '2020',
            'documents' => [],
        ],
        [
            'id' => 'ep-2019',
            'label' => '2019',
            'documents' => [],
        ],
        [
            'id' => 'ep-2018',
            'label' => '2018',
            'documents' => [],
        ],
    ],
];
