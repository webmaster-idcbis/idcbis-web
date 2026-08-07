<?php

/**
 * Contenido de /plan-anticorrupcion tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'paac_page_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Plan anticorrupción',
        'content' => '',
        'fontSize' => '16px',
        'subtitle' => 'Información pública
Consulta el Plan Anticorrupción y de Atención al Ciudadano (PAAC) del IDCBIS y sus seguimientos por vigencia.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'paac_page_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'paac-2022',
                'label' => '2022',
                'documents' => [
                    [
                        'id' => 'paac-2022-01',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Enero-Abril 2022',
                        'publishedAt' => '12 Mayo 2022',
                    ],
                    [
                        'id' => 'paac-2022-02',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Mayo-Agosto 2022',
                        'publishedAt' => '8 Septiembre 2022',
                    ],
                    [
                        'id' => 'paac-2022-03',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Septiembre-Diciembre 2022',
                        'publishedAt' => '16 Enero 2023',
                    ],
                    [
                        'id' => 'paac-2022-04',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2022',
                        'publishedAt' => '25 Enero 2022',
                    ],
                ],
            ],
            [
                'id' => 'paac-2021',
                'label' => '2021',
                'documents' => [
                    [
                        'id' => 'paac-2021-01',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Enero-Abril 2021',
                        'publishedAt' => '19 Mayo 2021',
                    ],
                    [
                        'id' => 'paac-2021-02',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Mayo-Agosto 2021',
                        'publishedAt' => '15 Septiembre 2021',
                    ],
                    [
                        'id' => 'paac-2021-03',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Septiembre-Diciembre 2021',
                        'publishedAt' => '19 Enero 2022',
                    ],
                    [
                        'id' => 'paac-2021-04',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2021',
                        'publishedAt' => '25 Enero 2021',
                    ],
                ],
            ],
            [
                'id' => 'paac-2020',
                'label' => '2020',
                'documents' => [
                    [
                        'id' => 'paac-2020-01',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2020',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'paac-2020-02',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Primer Semestre',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'paac-2020-03',
                        'url' => '',
                        'title' => 'Seguimiento PAAC – Segundo Semestre',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'paac-2019',
                'label' => '2019',
                'documents' => [
                    [
                        'id' => 'paac-2019-01',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2019',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'paac-2018',
                'label' => '2018',
                'documents' => [
                    [
                        'id' => 'paac-2018-01',
                        'url' => '',
                        'title' => 'Seguimiento plan anticorrupción y de atención al usuario 2018-2',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'paac-2018-02',
                        'url' => '',
                        'title' => 'Seguimiento plan anticorrupción y de atención al usuario 2018',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'paac-2018-03',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2018',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'paac-2017',
                'label' => '2017',
                'documents' => [
                    [
                        'id' => 'paac-2017-01',
                        'url' => '',
                        'title' => 'Seguimiento plan anticorrupción y de atención al usuario 2017',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'paac-2017-02',
                        'url' => '',
                        'title' => 'Plan anticorrupción 2017',
                        'publishedAt' => '',
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
