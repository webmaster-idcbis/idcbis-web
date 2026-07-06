<?php

/**
 * Bloque idcbis-documents-page — Plan anticorrupción.
 * Fuente: https://idcbis.org.co/plan-anticorrupcion/
 */

$doc = static function (
    string $id,
    string $title,
    string $publishedAt = '',
    string $url = '',
): array {
    return compact('id', 'title', 'publishedAt', 'url');
};

return [
    'id' => 'paac_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Plan anticorrupción',
    'heroSubtitle' => 'Consulta el Plan Anticorrupción y de Atención al Ciudadano (PAAC) del IDCBIS y sus seguimientos por vigencia.',
    'intro' => 'Selecciona un año en el menú lateral para ver los documentos publicados. Cada informe incluye su fecha de publicación oficial cuando está disponible.',
    'layout' => 'sidebar',
    'documentColumns' => 2,
    'showSearch' => true,
    'groups' => [
        [
            'id' => 'paac-2022',
            'label' => '2022',
            'documents' => [
                $doc('paac-2022-01', 'Seguimiento PAAC – Enero-Abril 2022', '12 Mayo 2022'),
                $doc('paac-2022-02', 'Seguimiento PAAC – Mayo-Agosto 2022', '8 Septiembre 2022'),
                $doc('paac-2022-03', 'Seguimiento PAAC – Septiembre-Diciembre 2022', '16 Enero 2023'),
                $doc('paac-2022-04', 'Plan anticorrupción 2022', '25 Enero 2022'),
            ],
        ],
        [
            'id' => 'paac-2021',
            'label' => '2021',
            'documents' => [
                $doc('paac-2021-01', 'Seguimiento PAAC – Enero-Abril 2021', '19 Mayo 2021'),
                $doc('paac-2021-02', 'Seguimiento PAAC – Mayo-Agosto 2021', '15 Septiembre 2021'),
                $doc('paac-2021-03', 'Seguimiento PAAC – Septiembre-Diciembre 2021', '19 Enero 2022'),
                $doc('paac-2021-04', 'Plan anticorrupción 2021', '25 Enero 2021'),
            ],
        ],
        [
            'id' => 'paac-2020',
            'label' => '2020',
            'documents' => [
                $doc('paac-2020-01', 'Plan anticorrupción 2020'),
                $doc('paac-2020-02', 'Seguimiento PAAC – Primer Semestre'),
                $doc('paac-2020-03', 'Seguimiento PAAC – Segundo Semestre'),
            ],
        ],
        [
            'id' => 'paac-2019',
            'label' => '2019',
            'documents' => [
                $doc('paac-2019-01', 'Plan anticorrupción 2019'),
            ],
        ],
        [
            'id' => 'paac-2018',
            'label' => '2018',
            'documents' => [
                $doc('paac-2018-01', 'Seguimiento plan anticorrupción y de atención al usuario 2018-2'),
                $doc('paac-2018-02', 'Seguimiento plan anticorrupción y de atención al usuario 2018'),
                $doc('paac-2018-03', 'Plan anticorrupción 2018'),
            ],
        ],
        [
            'id' => 'paac-2017',
            'label' => '2017',
            'documents' => [
                $doc('paac-2017-01', 'Seguimiento plan anticorrupción y de atención al usuario 2017'),
                $doc('paac-2017-02', 'Plan anticorrupción 2017'),
            ],
        ],
    ],
];
