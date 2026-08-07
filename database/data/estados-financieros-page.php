<?php

/**
 * Bloque idcbis-documents-page — Estados Financieros.
 * Fuente: https://idcbis.org.co/estados-financieros/
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
    'id' => 'ef_page_page',
    'type' => 'idcbis-documents-page',
    'content' => '',
    'fullBleed' => true,
    'eyebrow' => 'Información pública',
    'heroTitle' => 'Estados Financieros',
    'heroSubtitle' => 'Consulta los estados financieros del IDCBIS por período de corte.',
    'intro' => '',
    'layout' => 'sidebar',
    'documentColumns' => 1,
    'showSearch' => true,
,
    'groups' => [
        [
            'id' => 'ef-dic-2025',
            'label' => 'Estados financieros a Diciembre de 2025',
            'documents' => [
                $doc('ef-dic25-1', 'Estados financiero a Diciembre 31 de 2025', '06 de Marzo 2026'),
                $doc('ef-dic25-2', 'Notas estados financiero a Diciembre 31 de 2025', '06 de Marzo 2026'),
            ],
        ],
        [
            'id' => 'ef-sep-2025',
            'label' => 'Estados financieros a Septiembre de 2025',
            'documents' => [
                $doc('ef-sep25-1', 'Estados financiero a Septiembre 30 de 2025', '28 de noviembre 2025'),
            ],
        ],
        [
            'id' => 'ef-jun-2025',
            'label' => 'Estados financieros a Junio de 2025',
            'documents' => [
                $doc('ef-jun25-1', 'Estados financiero a Junio 30 de 2025', '01 de septiembre 2025'),
            ],
        ],
        [
            'id' => 'ef-mar-2025',
            'label' => 'Estados financieros a Marzo de 2025',
            'documents' => [
                $doc('ef-mar25-1', 'Estados financiero a Marzo 31 de 2025', '30 de mayo 2025'),
            ],
        ],
        [
            'id' => 'ef-dic-2024',
            'label' => 'Estados financieros a Diciembre de 2024',
            'documents' => [
                $doc('ef-dic24-1', 'Estado de situación financiera', '31 de Diciembre 2024'),
                $doc('ef-dic24-2', 'Notas estados financieros 2024', '31 de Diciembre 2024'),
            ],
        ],
        [
            'id' => 'ef-sep-2024',
            'label' => 'Estados financieros a Septiembre de 2024',
            'documents' => [
                $doc('ef-sep24-1', 'Estado de resultados', '29 de Noviembre 2024'),
                $doc('ef-sep24-2', 'Estado de cambio en el patrimonio', '29 de Noviembre 2024'),
                $doc('ef-sep24-3', 'Estado de situación financiera', '29 de Noviembre 2024'),
            ],
        ],
        [
            'id' => 'ef-jun-2024',
            'label' => 'Estados financieros a Junio de 2024',
            'documents' => [
                $doc('ef-jun24-1', 'Estado de resultados', '29 de agosto 2024'),
                $doc('ef-jun24-2', 'Estado de flujo de efectivo', '29 de agosto 2024'),
                $doc('ef-jun24-3', 'Estado de cambio en el patrimonio', '29 de agosto 2024'),
                $doc('ef-jun24-4', 'Estado de situación financiera', '29 de agosto 2024'),
            ],
        ],
        [
            'id' => 'ef-ene-mar-2024',
            'label' => 'Estados financieros de Enero – Marzo 2024',
            'documents' => [
                $doc('ef-q1-24-1', 'Estado de resultados', '16 de Mayo 2024'),
                $doc('ef-q1-24-2', 'Estado de cambio en el patrimonio', '16 de Mayo 2024'),
                $doc('ef-q1-24-3', 'Estado de situación financiera', '16 de Mayo 2024'),
            ],
        ],
        [
            'id' => 'ef-dic-2023',
            'label' => 'Estados financieros a Diciembre de 2023',
            'documents' => [
                $doc('ef-dic23-res', 'Estado de resultados', '29 de febrero 2024'),
                $doc('ef-dic23-flujo', 'Estado de flujo de efectivo', '29 de febrero 2024'),
                $doc('ef-dic23-pat', 'Estado de cambio en el patrimonio', '29 de febrero 2024'),
                $doc('ef-dic23-sit', 'Estado de situación financiera', '29 de febrero 2024'),
                $doc('ef-dic23-notas', 'Notas estados financieros 2023', '29 de febrero 2024'),
            ],
        ],
        [
            'id' => 'ef-nov-2023',
            'label' => 'Estados financieros a Noviembre de 2023',
            'documents' => [
                $doc('ef-nov23-res', 'Estado de resultados', '5 de Enero 2024'),
                $doc('ef-nov23-flujo', 'Estado de flujo de efectivo', '5 de Enero 2024'),
                $doc('ef-nov23-pat', 'Estado de cambio en el patrimonio', '5 de Enero 2024'),
                $doc('ef-nov23-sit', 'Estado de situación financiera', '5 de Enero 2024'),
            ],
        ],
        [
            'id' => 'ef-oct-2023',
            'label' => 'Estados financieros a Octubre de 2023',
            'documents' => [
                $doc('ef-oct23-res', 'Estado de resultados', '13 de Diciembre 2023'),
                $doc('ef-oct23-flujo', 'Estado de flujo de efectivo', '13 de Diciembre 2023'),
                $doc('ef-oct23-pat', 'Estado de cambio en el patrimonio', '13 de Diciembre 2023'),
                $doc('ef-oct23-sit', 'Estado de situación financiera', '13 de Diciembre 2023'),
            ],
        ],
        [
            'id' => 'ef-sep-2023',
            'label' => 'Estados financieros a Septiembre de 2023',
            'documents' => [
                $doc('ef-sep23-res', 'Estado de resultados', '8 de Noviembre 2023'),
                $doc('ef-sep23-flujo', 'Estado de flujo de efectivo', '8 de Noviembre 2023'),
                $doc('ef-sep23-pat', 'Estado de cambio en el patrimonio', '8 de Noviembre 2023'),
                $doc('ef-sep23-sit', 'Estado de situación financiera', '8 de Noviembre 2023'),
            ],
        ],
        [
            'id' => 'ef-ago-2023',
            'label' => 'Estados financieros a Agosto de 2023',
            'documents' => [
                $doc('ef-ago23-res', 'Estado de resultados', '27 de Octubre 2023'),
                $doc('ef-ago23-flujo', 'Estado de flujo de efectivo', '27 de Octubre 2023'),
                $doc('ef-ago23-pat', 'Estado de cambio en el patrimonio', '27 de Octubre 2023'),
                $doc('ef-ago23-sit', 'Estado de situación financiera', '27 de Octubre 2023'),
            ],
        ],
        [
            'id' => 'ef-jul-2023',
            'label' => 'Estados financieros a Julio de 2023',
            'documents' => [
                $doc('ef-jul23-res', 'Estado de resultados', '7 de Septiembre 2023'),
                $doc('ef-jul23-flujo', 'Estado de flujo de efectivo', '7 de Septiembre 2023'),
                $doc('ef-jul23-pat', 'Estado de cambio en el patrimonio', '7 de Septiembre 2023'),
                $doc('ef-jul23-sit', 'Estado de situación financiera', '7 de Septiembre 2023'),
            ],
        ],
        [
            'id' => 'ef-jun-2023',
            'label' => 'Estados financieros a Junio de 2023',
            'documents' => [
                $doc('ef-jun23-res', 'Estado de resultados', '1 de agosto 2023'),
                $doc('ef-jun23-flujo', 'Estado de flujo de efectivo', '1 de agosto 2023'),
                $doc('ef-jun23-pat', 'Estado de cambio en el patrimonio', '1 de agosto 2023'),
                $doc('ef-jun23-sit', 'Estado de situación financiera', '1 de agosto 2023'),
            ],
        ],
        [
            'id' => 'ef-may-2023',
            'label' => 'Estados financieros a Mayo de 2023',
            'documents' => [
                $doc('ef-may23-res', 'Estado de resultados', '30 de junio 2023'),
                $doc('ef-may23-flujo', 'Estado de flujo de efectivo', '30 de junio 2023'),
                $doc('ef-may23-pat', 'Estado de cambio en el patrimonio', '30 de junio 2023'),
                $doc('ef-may23-sit', 'Estado de situación financiera', '30 de junio 2023'),
            ],
        ],
        [
            'id' => 'ef-abr-2023',
            'label' => 'Estados financieros a Abril de 2023',
            'documents' => [
                $doc('ef-abr23-res', 'Estado de resultados', '31 de mayo 2023'),
                $doc('ef-abr23-flujo', 'Estado de flujo de efectivo', '31 de mayo 2023'),
                $doc('ef-abr23-pat', 'Estado de cambio en el patrimonio', '31 de mayo 2023'),
                $doc('ef-abr23-sit', 'Estado de situación financiera', '31 de mayo 2023'),
            ],
        ],
        [
            'id' => 'ef-mar-2023',
            'label' => 'Estados financieros a Marzo de 2023',
            'documents' => [
                $doc('ef-mar23-res', 'Estado de resultados', '2 de mayo 2023'),
                $doc('ef-mar23-flujo', 'Estado de flujo de efectivo', '2 de mayo 2023'),
                $doc('ef-mar23-pat', 'Estado de cambio en el patrimonio', '2 de mayo 2023'),
                $doc('ef-mar23-sit', 'Estado de situación financiera', '2 de mayo 2023'),
            ],
        ],
        [
            'id' => 'ef-feb-2023',
            'label' => 'Estados financieros a Febrero de 2023',
            'documents' => [
                $doc('ef-feb23-res', 'Estado de resultados', '25 de abril 2023'),
                $doc('ef-feb23-flujo', 'Estado de flujo de efectivo', '25 de abril 2023'),
                $doc('ef-feb23-pat', 'Estado de cambio en el patrimonio', '25 de abril 2023'),
                $doc('ef-feb23-sit', 'Estado de situación financiera', '25 de abril 2023'),
            ],
        ],
        [
            'id' => 'ef-ene-2023',
            'label' => 'Estados financieros a Enero de 2023',
            'documents' => [
                $doc('ef-ene23-res', 'Estado de resultados', '07 de marzo 2023'),
                $doc('ef-ene23-flujo', 'Estado de flujo de efectivo', '07 de marzo 2023'),
                $doc('ef-ene23-pat', 'Estado de cambio en el patrimonio', '07 de marzo 2023'),
                $doc('ef-ene23-sit', 'Estado de situación financiera', '07 de marzo 2023'),
            ],
        ],
        [
            'id' => 'ef-dic-2022',
            'label' => 'Estados financieros a Diciembre de 2022',
            'documents' => [
                $doc('ef-dic22-res', 'Estado de resultados', '22 de febrero 2023'),
                $doc('ef-dic22-flujo', 'Estado de flujo de efectivo', '22 de febrero 2023'),
                $doc('ef-dic22-pat', 'Estado de cambio en el patrimonio', '22 de febrero 2023'),
                $doc('ef-dic22-sit', 'Estado de situación financiera', '22 de febrero 2023'),
                $doc('ef-dic22-notas', 'Notas estados financieros 2022', '22 de febrero 2023'),
            ],
        ],
        [
            'id' => 'ef-nov-2022',
            'label' => 'Estados financieros a Noviembre de 2022',
            'documents' => [
                $doc('ef-nov22-res', 'Estado de resultados', '23 de diciembre 2022'),
                $doc('ef-nov22-flujo', 'Estado de flujo de efectivo', '23 de diciembre 2022'),
                $doc('ef-nov22-pat', 'Estado de cambio en el patrimonio', '23 de diciembre 2022'),
                $doc('ef-nov22-sit', 'Estado de situación financiera', '23 de diciembre 2022'),
            ],
        ],
        [
            'id' => 'ef-oct-2022',
            'label' => 'Estados financieros a Octubre de 2022',
            'documents' => [
                $doc('ef-oct-2022-res', 'Estado de resultados'),
                $doc('ef-oct-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-oct-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-oct-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2022',
            'label' => 'Estados financieros a Septiembre de 2022',
            'documents' => [
                $doc('ef-sep-2022-res', 'Estado de resultados'),
                $doc('ef-sep-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-ago-2022',
            'label' => 'Estados financieros a Agosto de 2022',
            'documents' => [
                $doc('ef-ago-2022-res', 'Estado de resultados'),
                $doc('ef-ago-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-ago-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-ago-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jul-2022',
            'label' => 'Estados financieros a Julio de 2022',
            'documents' => [
                $doc('ef-jul-2022-res', 'Estado de resultados'),
                $doc('ef-jul-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jul-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jul-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2022',
            'label' => 'Estados financieros a Junio de 2022',
            'documents' => [
                $doc('ef-jun-2022-res', 'Estado de resultados'),
                $doc('ef-jun-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-may-2022',
            'label' => 'Estados financieros a Mayo de 2022',
            'documents' => [
                $doc('ef-may-2022-res', 'Estado de resultados'),
                $doc('ef-may-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-may-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-may-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-abr-2022',
            'label' => 'Estados financieros a Abril de 2022',
            'documents' => [
                $doc('ef-abr-2022-res', 'Estado de resultados'),
                $doc('ef-abr-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-abr-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-abr-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-mar-2022',
            'label' => 'Estados financieros a Marzo de 2022',
            'documents' => [
                $doc('ef-mar-2022-res', 'Estado de resultados'),
                $doc('ef-mar-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-mar-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-mar-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-feb-2022',
            'label' => 'Estados financieros a Febrero de 2022',
            'documents' => [
                $doc('ef-feb-2022-res', 'Estado de resultados'),
                $doc('ef-feb-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-feb-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-feb-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-ene-2022',
            'label' => 'Estados financieros a Enero de 2022',
            'documents' => [
                $doc('ef-ene-2022-res', 'Estado de resultados'),
                $doc('ef-ene-2022-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-ene-2022-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-ene-2022-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-dic-2021',
            'label' => 'Estados financieros a Diciembre de 2021',
            'documents' => [
                $doc('ef-dic-2021-res', 'Estado de resultados'),
                $doc('ef-dic-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-dic-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-dic-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-nov-2021',
            'label' => 'Estados financieros a Noviembre de 2021',
            'documents' => [
                $doc('ef-nov-2021-res', 'Estado de resultados'),
                $doc('ef-nov-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-nov-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-nov-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-oct-2021',
            'label' => 'Estados financieros a Octubre de 2021',
            'documents' => [
                $doc('ef-oct-2021-res', 'Estado de resultados'),
                $doc('ef-oct-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-oct-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-oct-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2021',
            'label' => 'Estados financieros a Septiembre de 2021',
            'documents' => [
                $doc('ef-sep-2021-res', 'Estado de resultados'),
                $doc('ef-sep-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-ago-2021',
            'label' => 'Estados financieros a Agosto de 2021',
            'documents' => [
                $doc('ef-ago-2021-res', 'Estado de resultados'),
                $doc('ef-ago-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-ago-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-ago-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jul-2021',
            'label' => 'Estados financieros a Julio de 2021',
            'documents' => [
                $doc('ef-jul-2021-res', 'Estado de resultados'),
                $doc('ef-jul-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jul-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jul-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2021',
            'label' => 'Estados financieros a Junio de 2021',
            'documents' => [
                $doc('ef-jun-2021-res', 'Estado de resultados'),
                $doc('ef-jun-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-may-2021',
            'label' => 'Estados financieros a Mayo de 2021',
            'documents' => [
                $doc('ef-may-2021-res', 'Estado de resultados'),
                $doc('ef-may-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-may-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-may-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-abr-2021',
            'label' => 'Estados financieros a Abril de 2021',
            'documents' => [
                $doc('ef-abr-2021-res', 'Estado de resultados'),
                $doc('ef-abr-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-abr-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-abr-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-mar-2021',
            'label' => 'Estados financieros a Marzo de 2021',
            'documents' => [
                $doc('ef-mar-2021-res', 'Estado de resultados'),
                $doc('ef-mar-2021-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-mar-2021-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-mar-2021-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-dic-2020',
            'label' => 'Estados financieros a Diciembre de 2020',
            'documents' => [
                $doc('ef-dic-2020-res', 'Estado de resultados'),
                $doc('ef-dic-2020-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-dic-2020-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-dic-2020-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2020',
            'label' => 'Estados financieros a Septiembre de 2020',
            'documents' => [
                $doc('ef-sep-2020-res', 'Estado de resultados'),
                $doc('ef-sep-2020-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2020-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2020-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2020',
            'label' => 'Estados financieros a Junio de 2020',
            'documents' => [
                $doc('ef-jun-2020-res', 'Estado de resultados'),
                $doc('ef-jun-2020-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2020-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2020-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-mar-2020',
            'label' => 'Estados financieros a Marzo de 2020',
            'documents' => [
                $doc('ef-mar-2020-res', 'Estado de resultados'),
                $doc('ef-mar-2020-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-mar-2020-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-mar-2020-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-dic-2019',
            'label' => 'Estados financieros a Diciembre de 2019',
            'documents' => [
                $doc('ef-dic-2019-res', 'Estado de resultados'),
                $doc('ef-dic-2019-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-dic-2019-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-dic-2019-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2019',
            'label' => 'Estados financieros a Septiembre de 2019',
            'documents' => [
                $doc('ef-sep-2019-res', 'Estado de resultados'),
                $doc('ef-sep-2019-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2019-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2019-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2019',
            'label' => 'Estados financieros a Junio de 2019',
            'documents' => [
                $doc('ef-jun-2019-res', 'Estado de resultados'),
                $doc('ef-jun-2019-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2019-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2019-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-mar-2019',
            'label' => 'Estados financieros a Marzo de 2019',
            'documents' => [
                $doc('ef-mar-2019-res', 'Estado de resultados'),
                $doc('ef-mar-2019-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-mar-2019-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-mar-2019-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-dic-2018',
            'label' => 'Estados financieros a Diciembre de 2018',
            'documents' => [
                $doc('ef-dic-2018-res', 'Estado de resultados'),
                $doc('ef-dic-2018-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-dic-2018-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-dic-2018-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2018',
            'label' => 'Estados financieros a Septiembre de 2018',
            'documents' => [
                $doc('ef-sep-2018-res', 'Estado de resultados'),
                $doc('ef-sep-2018-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2018-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2018-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2018',
            'label' => 'Estados financieros a Junio de 2018',
            'documents' => [
                $doc('ef-jun-2018-res', 'Estado de resultados'),
                $doc('ef-jun-2018-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2018-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2018-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-mar-2018',
            'label' => 'Estados financieros a Marzo de 2018',
            'documents' => [
                $doc('ef-mar-2018-res', 'Estado de resultados'),
                $doc('ef-mar-2018-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-mar-2018-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-mar-2018-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-dic-2017',
            'label' => 'Estados financieros a Diciembre de 2017',
            'documents' => [
                $doc('ef-dic-2017-res', 'Estado de resultados'),
                $doc('ef-dic-2017-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-dic-2017-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-dic-2017-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-sep-2017',
            'label' => 'Estados financieros a Septiembre de 2017',
            'documents' => [
                $doc('ef-sep-2017-res', 'Estado de resultados'),
                $doc('ef-sep-2017-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-sep-2017-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-sep-2017-sit', 'Estado de situación financiera'),
            ],
        ],
        [
            'id' => 'ef-jun-2017',
            'label' => 'Estados financieros a Junio de 2017',
            'documents' => [
                $doc('ef-jun-2017-res', 'Estado de resultados'),
                $doc('ef-jun-2017-flujo', 'Estado de flujo de efectivo'),
                $doc('ef-jun-2017-pat', 'Estado de cambio en el patrimonio'),
                $doc('ef-jun-2017-sit', 'Estado de situación financiera'),
            ],
        ],
    ],
];

return $page;
