<?php

/**
 * Contenido de /normativa tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'nrm_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Normativa',
        'content' => '',
        'subtitle' => 'Información pública
Consulta el normograma, el Registro Distrital, SUIN, SUCOP y las denuncias de acoso sexual laboral del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'nrm_intro',
        'type' => 'text',
        'color' => '#4b5563',
        'margin' => '2rem auto',
        'content' => 'Consulte el normograma institucional, el Registro Distrital (Gaceta Oficial) en cumplimiento de la Resolución 440 de 2018 de la Secretaría General, el Sistema Único de Información Normativa (SUIN) y el Sistema Único de Consulta Pública (SUCOP) para la participación ciudadana en la expedición de normas. También se publican las denuncias de acoso sexual laboral conforme al numeral 7 del artículo 11 de la Ley 2365 de 2024.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '720px',
        'fullBleed' => false,
        'textAlign' => 'center',
        'blockLabel' => 'Introducción',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'nrm_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'nrm-normograma',
                'label' => 'Normograma',
                'documents' => [
                    [
                        'id' => 'nrm-ng-matriz',
                        'url' => 'https://idcbis.org.co/documentos/normatividad/Matriz%20de%20requisitos%20legales%20y%20otros%20requisitos%20IDCBIS_V03%202026.pdf',
                        'title' => 'Normograma - Matriz de requisitos legales y otros requisitos',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'nrm-ng-761',
                        'url' => 'https://idcbis.org.co/documentos/normatividad/Acuerdo_761_de_2020_Plan_de_Desarrollo_2020_2024.pdf',
                        'title' => 'Acuerdo Distrital 761 de 2020',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'nrm-ng-641',
                        'url' => 'https://idcbis.org.co/documentos/normatividad/acuerdo_641_de_20166.pdf',
                        'title' => 'Acuerdo 641 de 2016',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'nrm-gaceta',
                'label' => 'Diario o Gaceta Oficial',
                'documents' => [
                    [
                        'id' => 'nrm-gaceta-link',
                        'url' => 'https://registrodistrital.secretariageneral.gov.co/',
                        'title' => 'Diario o Gaceta Oficial — Registro Distrital',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'nrm-suin',
                'label' => 'SUIN',
                'documents' => [
                    [
                        'id' => 'nrm-suin-link',
                        'url' => 'https://www.suin-juriscol.gov.co/',
                        'title' => 'Sistema Único de Información Normativa',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'nrm-sucop',
                'label' => 'SUCOP',
                'documents' => [
                    [
                        'id' => 'nrm-sucop-link',
                        'url' => 'https://www.sucop.gov.co/',
                        'title' => 'Sistema Único de Consulta Pública — participación ciudadana en la expedición de normas',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'nrm-acoso',
                'label' => 'Denuncias Acoso Sexual Laboral',
                'documents' => [
                    [
                        'id' => 'nrm-asl-2026-06-03',
                        'url' => 'https://idcbis.org.co/documentos/normatividad/Certificaci%C3%B3n%20Final%20-%20Denuncia%20Acoso%20sexual.pdf',
                        'title' => 'Denuncia - 3 de junio de 2026',
                        'publishedAt' => '',
                    ],
                ],
            ],
        ],
        'layout' => 'sidebar',
        'fullBleed' => true,
        'blockLabel' => 'Listado de documentos',
        'showSearch' => true,
        'documentColumns' => 1,
    ],
];
