<?php

/**
 * Bloque idcbis-documents-page — Contratación bienes y servicios.
 * Fuente: https://idcbis.org.co/contratacion-bienes-y-servicios/
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
    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre',
];

$monthKey = static fn (int $month): string => str_pad((string) $month, 2, '0', STR_PAD_LEFT);

$prestacionYModificaciones = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
    bool $capitalizeMonth = false,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $name = $monthNames[$month];
        $label = $capitalizeMonth ? $name : strtolower($name);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-ps", "Contratación prestación de servicios {$label} {$year}");
        $documents[] = $doc("{$key}-mod", "Modificaciones contractuales {$label} {$year}");
    }

    return $documents;
};

$bienesPrestacionModificaciones = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $label = strtolower($monthNames[$month]);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-bs", "Contratación bienes y servicios {$label} {$year}");
        $documents[] = $doc("{$key}-ps", "Contratación prestación de servicios {$label} {$year}");
        $documents[] = $doc("{$key}-mod", "Modificaciones contractuales {$label} {$year}");
    }

    return $documents;
};

$bienesYPrestacion = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $label = strtolower($monthNames[$month]);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-bs", "Contratación bienes y servicios {$label} {$year}");
        $documents[] = $doc("{$key}-ps", "Contratación prestación de servicios {$label} {$year}");
    }

    return $documents;
};

$generalYModificaciones = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $label = strtolower($monthNames[$month]);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-gen", "Contratación general {$label} {$year}");
        $documents[] = $doc("{$key}-mod", "Modificaciones contractuales {$label} {$year}");
    }

    return $documents;
};

$bienesPrestacionConModificacionesDesde = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
    int $modificacionesFromMonth,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $label = strtolower($monthNames[$month]);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-bs", "Contratación bienes y servicios {$label} {$year}");
        $documents[] = $doc("{$key}-ps", "Contratación prestación de servicios {$label} {$year}");

        if ($month >= $modificacionesFromMonth) {
            $documents[] = $doc("{$key}-mod", "Modificaciones contractuales {$label} {$year}");
        }
    }

    return $documents;
};

$soloBienes = static function (
    int $year,
    int $fromMonth,
    int $toMonth,
) use ($doc, $monthNames, $monthKey): array {
    $documents = [];

    for ($month = $fromMonth; $month <= $toMonth; $month++) {
        $label = strtolower($monthNames[$month]);
        $key = "cbs-{$year}-{$monthKey($month)}";

        $documents[] = $doc("{$key}-bs", "Contratación bienes y servicios {$label} {$year}");
    }

    return $documents;
};

$informesTransparencia2025 = static function () use ($doc): array {
    return [
        $doc('cbs-2025-03-con', 'Informe de Transparencia y ética pública Marzo 2025 – CONTRATOS', '28 Abril 2025'),
        $doc('cbs-2025-03-mod', 'Informe de Transparencia y Ética Pública Marzo 2025 – MODIFICACIONES', '28 Abril 2025'),
        $doc('cbs-2025-04-con', 'Informe de Transparencia y Ética Pública Abril 2025 – CONTRATOS 0001', '23 Mayo 2025'),
        $doc('cbs-2025-04-mod', 'Informe de Transparencia y Ética Pública Abril 2025 – MODIFICACIONES', '23 Mayo 2025'),
        $doc('cbs-2025-05-con', 'Informe de Transparencia y Ética Pública Mayo 2025 – CONTRATOS', '10 Junio 2025'),
        $doc('cbs-2025-05-mod', 'Informe de Transparencia y Ética Pública Mayo 2025 – MODIFICACIONES', '10 Junio 2025'),
        $doc('cbs-2025-06-con', 'Informe de Transparencia y Ética Pública Junio 2025 – CONTRATOS', '10 Julio 2025'),
        $doc('cbs-2025-06-mod', 'Informe de Transparencia y Ética Pública Junio 2025 – MODIFICACIONES', '10 Julio 2025'),
        $doc('cbs-2025-07-con', 'Informe de Transparencia y Ética Pública Julio 2025 – CONTRATOS', '19 Agosto 2025'),
        $doc('cbs-2025-07-mod', 'Informe de Transparencia y Ética Pública Julio 2025 – MODIFICACIONES', '19 Agosto 2025'),
        $doc('cbs-2025-08-con', 'Informe de Transparencia y Ética Pública Agosto 2025 – CONTRATOS', '19 Agosto 2025'),
        $doc('cbs-2025-08-mod', 'Informe de Transparencia y Ética Pública Agosto 2025 – MODIFICACIONES', '19 Agosto 2025'),
        $doc('cbs-2025-09-con', 'Informe de Transparencia y Ética Pública Septiembre 2025 – CONTRATOS', '01 Octubre 2025'),
        $doc('cbs-2025-09-mod', 'Informe de Transparencia y Ética Pública Septiembre 2025 – MODIFICACIONES', '01 Octubre 2025'),
        $doc('cbs-2025-10-con', 'Informe de Transparencia y Ética Pública Octubre 2025 – CONTRATOS', '20 Noviembre 2025'),
        $doc('cbs-2025-10-mod', 'Informe de Transparencia y Ética Pública Octubre 2025 – MODIFICACIONES', '20 Noviembre 2025'),
        $doc('cbs-2025-11-con', 'Informe de Transparencia y Ética Pública Noviembre 2025 – CONTRATOS', '20 Diciembre 2025'),
        $doc('cbs-2025-11-mod', 'Informe de Transparencia y Ética Pública Noviembre 2025 – MODIFICACIONES', '20 Diciembre 2025'),
        $doc('cbs-2025-12-con', 'Informe de Transparencia y Ética Pública Diciembre 2025 – CONTRATOS', '16 Enero 2026'),
        $doc('cbs-2025-12-mod', 'Informe de Transparencia y Ética Pública Diciembre 2025 – MODIFICACIONES', '16 Enero 2026'),
    ];
};

return [
    'id' => 'cbs_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Contratación bienes y servicios',
    'heroSubtitle' => 'Consulta el manual de contratación y los informes mensuales de contratos y modificaciones contractuales del IDCBIS.',
    'intro' => 'Selecciona una sección en el menú lateral. Cada documento incluye su fecha de publicación oficial cuando está disponible.',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
    'groups' => [
        [
            'id' => 'cbs-manual',
            'label' => 'Manual',
            'documents' => [
                $doc('cbs-manual-01', 'Manual de contratación de bienes y servicios'),
            ],
        ],
        [
            'id' => 'cbs-2026',
            'label' => '2026',
            'documents' => $prestacionYModificaciones(2026, 1, 5, true),
        ],
        [
            'id' => 'cbs-2025',
            'label' => '2025',
            'documents' => array_merge(
                $prestacionYModificaciones(2025, 1, 2),
                $informesTransparencia2025(),
            ),
        ],
        [
            'id' => 'cbs-2024',
            'label' => '2024',
            'documents' => array_merge(
                $bienesPrestacionModificaciones(2024, 1, 7),
                $generalYModificaciones(2024, 8, 12),
            ),
        ],
        [
            'id' => 'cbs-2023',
            'label' => '2023',
            'documents' => array_merge(
                [$doc('cbs-2023-01-ps', 'Contratación prestación de servicios enero 2023')],
                $bienesYPrestacion(2023, 2, 7),
                $bienesPrestacionConModificacionesDesde(2023, 8, 12, 8),
            ),
        ],
        [
            'id' => 'cbs-2022',
            'label' => '2022',
            'documents' => $bienesYPrestacion(2022, 1, 12),
        ],
        [
            'id' => 'cbs-2021',
            'label' => '2021',
            'documents' => $bienesYPrestacion(2021, 1, 12),
        ],
        [
            'id' => 'cbs-2020',
            'label' => '2020',
            'documents' => array_merge(
                [$doc('cbs-2020-01-bs', 'Contratación bienes y servicios enero 2020')],
                $bienesYPrestacion(2020, 2, 12),
            ),
        ],
        [
            'id' => 'cbs-2019',
            'label' => '2019',
            'documents' => array_merge(
                $bienesYPrestacion(2019, 1, 4),
                $soloBienes(2019, 5, 12),
            ),
        ],
    ],
];
