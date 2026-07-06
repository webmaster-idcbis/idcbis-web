<?php

/**
 * Bloque idcbis-documents-page — Estados Financieros.
 * Fuente: https://idcbis.org.co/estados-financieros/
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt = '',
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

$estadosEstandar = static function (string $prefix, string $published = '') use ($doc): array {
    return [
        $doc("{$prefix}-res", 'Estado de resultados', $published),
        $doc("{$prefix}-flujo", 'Estado de flujo de efectivo', $published),
        $doc("{$prefix}-pat", 'Estado de cambio en el patrimonio', $published),
        $doc("{$prefix}-sit", 'Estado de situación financiera', $published),
    ];
};

$periodos = [
  'dic-2025' => 'Estados financieros a Diciembre de 2025',
  'sep-2025' => 'Estados financieros a Septiembre de 2025',
  'jun-2025' => 'Estados financieros a Junio de 2025',
  'mar-2025' => 'Estados financieros a Marzo de 2025',
  'dic-2024' => 'Estados financieros a Diciembre de 2024',
  'sep-2024' => 'Estados financieros a Septiembre de 2024',
  'jun-2024' => 'Estados financieros a Junio de 2024',
  'ene-mar-2024' => 'Estados financieros de Enero – Marzo 2024',
  'dic-2023' => 'Estados financieros a Diciembre de 2023',
  'nov-2023' => 'Estados financieros a Noviembre de 2023',
  'oct-2023' => 'Estados financieros a Octubre de 2023',
  'sep-2023' => 'Estados financieros a Septiembre de 2023',
  'ago-2023' => 'Estados financieros a Agosto de 2023',
  'jul-2023' => 'Estados financieros a Julio de 2023',
  'jun-2023' => 'Estados financieros a Junio de 2023',
  'may-2023' => 'Estados financieros a Mayo de 2023',
  'abr-2023' => 'Estados financieros a Abril de 2023',
  'mar-2023' => 'Estados financieros a Marzo de 2023',
  'feb-2023' => 'Estados financieros a Febrero de 2023',
  'ene-2023' => 'Estados financieros a Enero de 2023',
  'dic-2022' => 'Estados financieros a Diciembre de 2022',
  'nov-2022' => 'Estados financieros a Noviembre de 2022',
  'oct-2022' => 'Estados financieros a Octubre de 2022',
  'sep-2022' => 'Estados financieros a Septiembre de 2022',
  'ago-2022' => 'Estados financieros a Agosto de 2022',
  'jul-2022' => 'Estados financieros a Julio de 2022',
  'jun-2022' => 'Estados financieros a Junio de 2022',
  'may-2022' => 'Estados financieros a Mayo de 2022',
  'abr-2022' => 'Estados financieros a Abril de 2022',
  'mar-2022' => 'Estados financieros a Marzo de 2022',
  'feb-2022' => 'Estados financieros a Febrero de 2022',
  'ene-2022' => 'Estados financieros a Enero de 2022',
  'dic-2021' => 'Estados financieros a Diciembre de 2021',
  'nov-2021' => 'Estados financieros a Noviembre de 2021',
  'oct-2021' => 'Estados financieros a Octubre de 2021',
  'sep-2021' => 'Estados financieros a Septiembre de 2021',
  'ago-2021' => 'Estados financieros a Agosto de 2021',
  'jul-2021' => 'Estados financieros a Julio de 2021',
  'jun-2021' => 'Estados financieros a Junio de 2021',
  'may-2021' => 'Estados financieros a Mayo de 2021',
  'abr-2021' => 'Estados financieros a Abril de 2021',
  'mar-2021' => 'Estados financieros a Marzo de 2021',
  'dic-2020' => 'Estados financieros a Diciembre de 2020',
  'sep-2020' => 'Estados financieros a Septiembre de 2020',
  'jun-2020' => 'Estados financieros a Junio de 2020',
  'mar-2020' => 'Estados financieros a Marzo de 2020',
  'dic-2019' => 'Estados financieros a Diciembre de 2019',
  'sep-2019' => 'Estados financieros a Septiembre de 2019',
  'jun-2019' => 'Estados financieros a Junio de 2019',
  'mar-2019' => 'Estados financieros a Marzo de 2019',
  'dic-2018' => 'Estados financieros a Diciembre de 2018',
  'sep-2018' => 'Estados financieros a Septiembre de 2018',
  'jun-2018' => 'Estados financieros a Junio de 2018',
  'mar-2018' => 'Estados financieros a Marzo de 2018',
  'dic-2017' => 'Estados financieros a Diciembre de 2017',
  'sep-2017' => 'Estados financieros a Septiembre de 2017',
  'jun-2017' => 'Estados financieros a Junio de 2017',
];

$documentosPorPeriodo = [
    'dic-2025' => [
        $doc('ef-dic25-1', 'Estados financiero a Diciembre 31 de 2025', '06 de Marzo 2026'),
        $doc('ef-dic25-2', 'Notas estados financiero a Diciembre 31 de 2025', '06 de Marzo 2026'),
    ],
    'sep-2025' => [
        $doc('ef-sep25-1', 'Estados financiero a Septiembre 30 de 2025', '28 de noviembre 2025'),
    ],
    'jun-2025' => [
        $doc('ef-jun25-1', 'Estados financiero a Junio 30 de 2025', '01 de septiembre 2025'),
    ],
    'mar-2025' => [
        $doc('ef-mar25-1', 'Estados financiero a Marzo 31 de 2025', '30 de mayo 2025'),
    ],
    'dic-2024' => [
        $doc('ef-dic24-1', 'Estado de situación financiera', '31 de Diciembre 2024'),
        $doc('ef-dic24-2', 'Notas estados financieros 2024', '31 de Diciembre 2024'),
    ],
    'sep-2024' => [
        $doc('ef-sep24-1', 'Estado de resultados', '29 de Noviembre 2024'),
        $doc('ef-sep24-2', 'Estado de cambio en el patrimonio', '29 de Noviembre 2024'),
        $doc('ef-sep24-3', 'Estado de situación financiera', '29 de Noviembre 2024'),
    ],
    'jun-2024' => [
        $doc('ef-jun24-1', 'Estado de resultados', '29 de agosto 2024'),
        $doc('ef-jun24-2', 'Estado de flujo de efectivo', '29 de agosto 2024'),
        $doc('ef-jun24-3', 'Estado de cambio en el patrimonio', '29 de agosto 2024'),
        $doc('ef-jun24-4', 'Estado de situación financiera', '29 de agosto 2024'),
    ],
    'ene-mar-2024' => [
        $doc('ef-q1-24-1', 'Estado de resultados', '16 de Mayo 2024'),
        $doc('ef-q1-24-2', 'Estado de cambio en el patrimonio', '16 de Mayo 2024'),
        $doc('ef-q1-24-3', 'Estado de situación financiera', '16 de Mayo 2024'),
    ],
    'dic-2023' => array_merge(
        $estadosEstandar('ef-dic23', '29 de febrero 2024'),
        [$doc('ef-dic23-notas', 'Notas estados financieros 2023', '29 de febrero 2024')],
    ),
    'nov-2023' => $estadosEstandar('ef-nov23', '5 de Enero 2024'),
    'oct-2023' => $estadosEstandar('ef-oct23', '13 de Diciembre 2023'),
    'sep-2023' => $estadosEstandar('ef-sep23', '8 de Noviembre 2023'),
    'ago-2023' => $estadosEstandar('ef-ago23', '27 de Octubre 2023'),
    'jul-2023' => $estadosEstandar('ef-jul23', '7 de Septiembre 2023'),
    'jun-2023' => $estadosEstandar('ef-jun23', '1 de agosto 2023'),
    'may-2023' => $estadosEstandar('ef-may23', '30 de junio 2023'),
    'abr-2023' => $estadosEstandar('ef-abr23', '31 de mayo 2023'),
    'mar-2023' => $estadosEstandar('ef-mar23', '2 de mayo 2023'),
    'feb-2023' => $estadosEstandar('ef-feb23', '25 de abril 2023'),
    'ene-2023' => $estadosEstandar('ef-ene23', '07 de marzo 2023'),
    'dic-2022' => array_merge(
        $estadosEstandar('ef-dic22', '22 de febrero 2023'),
        [$doc('ef-dic22-notas', 'Notas estados financieros 2022', '22 de febrero 2023')],
    ),
    'nov-2022' => $estadosEstandar('ef-nov22', '23 de diciembre 2022'),
];

$groups = [];
foreach ($periodos as $slug => $label) {
    $groups[] = [
        'id' => 'ef-'.$slug,
        'label' => $label,
        'documents' => $documentosPorPeriodo[$slug] ?? $estadosEstandar('ef-'.$slug),
    ];
}

return [
    'id' => 'ef_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Estados Financieros',
    'heroSubtitle' => 'Consulta los estados financieros del IDCBIS por período de corte.',
    'intro' => 'Selecciona un período en el menú lateral para ver los documentos publicados. Cada informe incluye su fecha de publicación oficial.',
    'layout' => 'sidebar',
    'documentColumns' => 1,
    'showSearch' => true,
    'groups' => $groups,
];
