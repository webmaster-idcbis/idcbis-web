<?php

/**
 * Contenido de /contratacion tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'ctr_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Contratación',
        'content' => '',
        'subtitle' => 'Información pública
Consulta el plan de necesidades, el plan anual de adquisiciones y los procesos contractuales del IDCBIS en SECOP.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'ctr_intro',
        'type' => 'text',
        'color' => '#4b5563',
        'margin' => '2rem auto',
        'content' => 'En SECOP I realice la búsqueda por Entidad Compradora con el nombre «BOGOTÁ D.C. - INSTITUTO DISTRITAL DE CIENCIA, BIOTECNOLOGÍA E INNOVACIÓN EN SALUD - IDCBIS». En SECOP II busque por Datos de la Entidad: «INSTITUTO DISTRITAL DE CIENCIA, BIOTECNOLOGIA E INNOVACIÓN EN SALUD - IDCBIS». Para el plan anual de adquisiciones, indique la vigencia a consultar, el nombre del instituto y pulse Search.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '720px',
        'fullBleed' => false,
        'textAlign' => 'center',
        'blockLabel' => 'Introducción',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'ctr_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'ctr-plan-necesidades',
                'label' => 'Plan de necesidades bienes y servicios',
                'documents' => [
                    [
                        'id' => 'ctr-pn-2019',
                        'url' => 'https://idcbis.org.co/pdf/plan-necesidades-de-bienes-2019.pdf',
                        'title' => 'Plan de necesidades de bienes 2019',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ctr-pn-2020',
                        'url' => 'https://idcbis.org.co/pdf/plan-necesidades-de-bienes-2020.pdf',
                        'title' => 'Plan de necesidades de bienes 2020',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ctr-pn-2021',
                        'url' => 'https://idcbis.org.co/pdf/plan-necesidades-de-bienes-2021.pdf',
                        'title' => 'Plan de necesidades de bienes 2021',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ctr-paa',
                'label' => 'Plan anual de adquisiciones - SECOP',
                'documents' => [
                    [
                        'id' => 'ctr-paa-link',
                        'url' => 'https://community.secop.gov.co/Public/App/AnnualPurchasingPlanManagementPublic/Index?currentLanguage=en&Page=login&Country=CO&SkinName=CCE',
                        'title' => 'Enlace al Plan anual de adquisiciones',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ctr-secop-i',
                'label' => 'SECOP I',
                'documents' => [
                    [
                        'id' => 'ctr-secop1-link',
                        'url' => 'https://www.contratos.gov.co/consultas/inicioConsulta.do',
                        'title' => 'Consultar procesos SECOP I — búsqueda por Entidad Compradora: BOGOTÁ D.C. - INSTITUTO DISTRITAL DE CIENCIA, BIOTECNOLOGÍA E INNOVACIÓN EN SALUD - IDCBIS',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ctr-secop-ii',
                'label' => 'SECOP II',
                'documents' => [
                    [
                        'id' => 'ctr-secop2-link',
                        'url' => 'https://community.secop.gov.co/Public/Tendering/ContractNoticeManagement/Index?currentLanguage=es-CO&Page=login&Country=CO&SkinName=CCE',
                        'title' => 'Consultar procesos SECOP II — búsqueda por Datos de la Entidad: INSTITUTO DISTRITAL DE CIENCIA, BIOTECNOLOGIA E INNOVACIÓN EN SALUD - IDCBIS',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ctr-info',
                'label' => 'Información contractual',
                'documents' => [
                    [
                        'id' => 'ctr-info-link',
                        'url' => 'https://idcbis.org.co/contratacion-bienes-y-servicios/',
                        'title' => 'Consultar información contractual de bienes y servicios',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ctr-manuales',
                'label' => 'Manuales',
                'documents' => [
                    [
                        'id' => 'ctr-man-1',
                        'url' => 'https://www.idcbis.org.co/pdf/IDCBIS-GGCC-MN-001-V7-MANUAL%20DE-CONTRATACION-DE%20-BIENES-Y-SERVICIOS.pdf',
                        'title' => 'Manual de contratación de bienes y servicios',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ctr-man-2',
                        'url' => 'https://www.idcbis.org.co/pdf/GUIA_ENTIDADES_DE_REGIMEN_ESPECIAL_DE_CONTRATACION-SECOP.pdf',
                        'title' => 'Guía entidades de régimen especial SECOP',
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
