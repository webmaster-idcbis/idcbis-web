<?php

/**
 * Contenido de /estados-financieros tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'ef_page_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Estados Financieros',
        'content' => '',
        'fontSize' => '16px',
        'subtitle' => 'Información pública
Consulta los estados financieros del IDCBIS por período de corte.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'ef_page_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'ef-dic-2025',
                'label' => 'Estados financieros a Diciembre de 2025',
                'documents' => [
                    [
                        'id' => 'ef-dic25-1',
                        'url' => '',
                        'title' => 'Estados financiero a Diciembre 31 de 2025',
                        'publishedAt' => '06 de Marzo 2026',
                    ],
                    [
                        'id' => 'ef-dic25-2',
                        'url' => '',
                        'title' => 'Notas estados financiero a Diciembre 31 de 2025',
                        'publishedAt' => '06 de Marzo 2026',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2025',
                'label' => 'Estados financieros a Septiembre de 2025',
                'documents' => [
                    [
                        'id' => 'ef-sep25-1',
                        'url' => '',
                        'title' => 'Estados financiero a Septiembre 30 de 2025',
                        'publishedAt' => '28 de noviembre 2025',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2025',
                'label' => 'Estados financieros a Junio de 2025',
                'documents' => [
                    [
                        'id' => 'ef-jun25-1',
                        'url' => '',
                        'title' => 'Estados financiero a Junio 30 de 2025',
                        'publishedAt' => '01 de septiembre 2025',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2025',
                'label' => 'Estados financieros a Marzo de 2025',
                'documents' => [
                    [
                        'id' => 'ef-mar25-1',
                        'url' => '',
                        'title' => 'Estados financiero a Marzo 31 de 2025',
                        'publishedAt' => '30 de mayo 2025',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2024',
                'label' => 'Estados financieros a Diciembre de 2024',
                'documents' => [
                    [
                        'id' => 'ef-dic24-1',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '31 de Diciembre 2024',
                    ],
                    [
                        'id' => 'ef-dic24-2',
                        'url' => '',
                        'title' => 'Notas estados financieros 2024',
                        'publishedAt' => '31 de Diciembre 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2024',
                'label' => 'Estados financieros a Septiembre de 2024',
                'documents' => [
                    [
                        'id' => 'ef-sep24-1',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '29 de Noviembre 2024',
                    ],
                    [
                        'id' => 'ef-sep24-2',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '29 de Noviembre 2024',
                    ],
                    [
                        'id' => 'ef-sep24-3',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '29 de Noviembre 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2024',
                'label' => 'Estados financieros a Junio de 2024',
                'documents' => [
                    [
                        'id' => 'ef-jun24-1',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '29 de agosto 2024',
                    ],
                    [
                        'id' => 'ef-jun24-2',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '29 de agosto 2024',
                    ],
                    [
                        'id' => 'ef-jun24-3',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '29 de agosto 2024',
                    ],
                    [
                        'id' => 'ef-jun24-4',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '29 de agosto 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-ene-mar-2024',
                'label' => 'Estados financieros de Enero – Marzo 2024',
                'documents' => [
                    [
                        'id' => 'ef-q1-24-1',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '16 de Mayo 2024',
                    ],
                    [
                        'id' => 'ef-q1-24-2',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '16 de Mayo 2024',
                    ],
                    [
                        'id' => 'ef-q1-24-3',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '16 de Mayo 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2023',
                'label' => 'Estados financieros a Diciembre de 2023',
                'documents' => [
                    [
                        'id' => 'ef-dic23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '29 de febrero 2024',
                    ],
                    [
                        'id' => 'ef-dic23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '29 de febrero 2024',
                    ],
                    [
                        'id' => 'ef-dic23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '29 de febrero 2024',
                    ],
                    [
                        'id' => 'ef-dic23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '29 de febrero 2024',
                    ],
                    [
                        'id' => 'ef-dic23-notas',
                        'url' => '',
                        'title' => 'Notas estados financieros 2023',
                        'publishedAt' => '29 de febrero 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-nov-2023',
                'label' => 'Estados financieros a Noviembre de 2023',
                'documents' => [
                    [
                        'id' => 'ef-nov23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '5 de Enero 2024',
                    ],
                    [
                        'id' => 'ef-nov23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '5 de Enero 2024',
                    ],
                    [
                        'id' => 'ef-nov23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '5 de Enero 2024',
                    ],
                    [
                        'id' => 'ef-nov23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '5 de Enero 2024',
                    ],
                ],
            ],
            [
                'id' => 'ef-oct-2023',
                'label' => 'Estados financieros a Octubre de 2023',
                'documents' => [
                    [
                        'id' => 'ef-oct23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '13 de Diciembre 2023',
                    ],
                    [
                        'id' => 'ef-oct23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '13 de Diciembre 2023',
                    ],
                    [
                        'id' => 'ef-oct23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '13 de Diciembre 2023',
                    ],
                    [
                        'id' => 'ef-oct23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '13 de Diciembre 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2023',
                'label' => 'Estados financieros a Septiembre de 2023',
                'documents' => [
                    [
                        'id' => 'ef-sep23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '8 de Noviembre 2023',
                    ],
                    [
                        'id' => 'ef-sep23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '8 de Noviembre 2023',
                    ],
                    [
                        'id' => 'ef-sep23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '8 de Noviembre 2023',
                    ],
                    [
                        'id' => 'ef-sep23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '8 de Noviembre 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-ago-2023',
                'label' => 'Estados financieros a Agosto de 2023',
                'documents' => [
                    [
                        'id' => 'ef-ago23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '27 de Octubre 2023',
                    ],
                    [
                        'id' => 'ef-ago23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '27 de Octubre 2023',
                    ],
                    [
                        'id' => 'ef-ago23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '27 de Octubre 2023',
                    ],
                    [
                        'id' => 'ef-ago23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '27 de Octubre 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-jul-2023',
                'label' => 'Estados financieros a Julio de 2023',
                'documents' => [
                    [
                        'id' => 'ef-jul23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '7 de Septiembre 2023',
                    ],
                    [
                        'id' => 'ef-jul23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '7 de Septiembre 2023',
                    ],
                    [
                        'id' => 'ef-jul23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '7 de Septiembre 2023',
                    ],
                    [
                        'id' => 'ef-jul23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '7 de Septiembre 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2023',
                'label' => 'Estados financieros a Junio de 2023',
                'documents' => [
                    [
                        'id' => 'ef-jun23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '1 de agosto 2023',
                    ],
                    [
                        'id' => 'ef-jun23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '1 de agosto 2023',
                    ],
                    [
                        'id' => 'ef-jun23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '1 de agosto 2023',
                    ],
                    [
                        'id' => 'ef-jun23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '1 de agosto 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-may-2023',
                'label' => 'Estados financieros a Mayo de 2023',
                'documents' => [
                    [
                        'id' => 'ef-may23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '30 de junio 2023',
                    ],
                    [
                        'id' => 'ef-may23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '30 de junio 2023',
                    ],
                    [
                        'id' => 'ef-may23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '30 de junio 2023',
                    ],
                    [
                        'id' => 'ef-may23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '30 de junio 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-abr-2023',
                'label' => 'Estados financieros a Abril de 2023',
                'documents' => [
                    [
                        'id' => 'ef-abr23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '31 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-abr23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '31 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-abr23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '31 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-abr23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '31 de mayo 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2023',
                'label' => 'Estados financieros a Marzo de 2023',
                'documents' => [
                    [
                        'id' => 'ef-mar23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '2 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-mar23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '2 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-mar23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '2 de mayo 2023',
                    ],
                    [
                        'id' => 'ef-mar23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '2 de mayo 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-feb-2023',
                'label' => 'Estados financieros a Febrero de 2023',
                'documents' => [
                    [
                        'id' => 'ef-feb23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '25 de abril 2023',
                    ],
                    [
                        'id' => 'ef-feb23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '25 de abril 2023',
                    ],
                    [
                        'id' => 'ef-feb23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '25 de abril 2023',
                    ],
                    [
                        'id' => 'ef-feb23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '25 de abril 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-ene-2023',
                'label' => 'Estados financieros a Enero de 2023',
                'documents' => [
                    [
                        'id' => 'ef-ene23-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '07 de marzo 2023',
                    ],
                    [
                        'id' => 'ef-ene23-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '07 de marzo 2023',
                    ],
                    [
                        'id' => 'ef-ene23-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '07 de marzo 2023',
                    ],
                    [
                        'id' => 'ef-ene23-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '07 de marzo 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2022',
                'label' => 'Estados financieros a Diciembre de 2022',
                'documents' => [
                    [
                        'id' => 'ef-dic22-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '22 de febrero 2023',
                    ],
                    [
                        'id' => 'ef-dic22-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '22 de febrero 2023',
                    ],
                    [
                        'id' => 'ef-dic22-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '22 de febrero 2023',
                    ],
                    [
                        'id' => 'ef-dic22-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '22 de febrero 2023',
                    ],
                    [
                        'id' => 'ef-dic22-notas',
                        'url' => '',
                        'title' => 'Notas estados financieros 2022',
                        'publishedAt' => '22 de febrero 2023',
                    ],
                ],
            ],
            [
                'id' => 'ef-nov-2022',
                'label' => 'Estados financieros a Noviembre de 2022',
                'documents' => [
                    [
                        'id' => 'ef-nov22-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '23 de diciembre 2022',
                    ],
                    [
                        'id' => 'ef-nov22-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '23 de diciembre 2022',
                    ],
                    [
                        'id' => 'ef-nov22-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '23 de diciembre 2022',
                    ],
                    [
                        'id' => 'ef-nov22-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '23 de diciembre 2022',
                    ],
                ],
            ],
            [
                'id' => 'ef-oct-2022',
                'label' => 'Estados financieros a Octubre de 2022',
                'documents' => [
                    [
                        'id' => 'ef-oct-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2022',
                'label' => 'Estados financieros a Septiembre de 2022',
                'documents' => [
                    [
                        'id' => 'ef-sep-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-ago-2022',
                'label' => 'Estados financieros a Agosto de 2022',
                'documents' => [
                    [
                        'id' => 'ef-ago-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jul-2022',
                'label' => 'Estados financieros a Julio de 2022',
                'documents' => [
                    [
                        'id' => 'ef-jul-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2022',
                'label' => 'Estados financieros a Junio de 2022',
                'documents' => [
                    [
                        'id' => 'ef-jun-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-may-2022',
                'label' => 'Estados financieros a Mayo de 2022',
                'documents' => [
                    [
                        'id' => 'ef-may-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-abr-2022',
                'label' => 'Estados financieros a Abril de 2022',
                'documents' => [
                    [
                        'id' => 'ef-abr-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2022',
                'label' => 'Estados financieros a Marzo de 2022',
                'documents' => [
                    [
                        'id' => 'ef-mar-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-feb-2022',
                'label' => 'Estados financieros a Febrero de 2022',
                'documents' => [
                    [
                        'id' => 'ef-feb-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-feb-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-feb-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-feb-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-ene-2022',
                'label' => 'Estados financieros a Enero de 2022',
                'documents' => [
                    [
                        'id' => 'ef-ene-2022-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ene-2022-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ene-2022-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ene-2022-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2021',
                'label' => 'Estados financieros a Diciembre de 2021',
                'documents' => [
                    [
                        'id' => 'ef-dic-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-nov-2021',
                'label' => 'Estados financieros a Noviembre de 2021',
                'documents' => [
                    [
                        'id' => 'ef-nov-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-nov-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-nov-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-nov-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-oct-2021',
                'label' => 'Estados financieros a Octubre de 2021',
                'documents' => [
                    [
                        'id' => 'ef-oct-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-oct-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2021',
                'label' => 'Estados financieros a Septiembre de 2021',
                'documents' => [
                    [
                        'id' => 'ef-sep-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-ago-2021',
                'label' => 'Estados financieros a Agosto de 2021',
                'documents' => [
                    [
                        'id' => 'ef-ago-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-ago-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jul-2021',
                'label' => 'Estados financieros a Julio de 2021',
                'documents' => [
                    [
                        'id' => 'ef-jul-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jul-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2021',
                'label' => 'Estados financieros a Junio de 2021',
                'documents' => [
                    [
                        'id' => 'ef-jun-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-may-2021',
                'label' => 'Estados financieros a Mayo de 2021',
                'documents' => [
                    [
                        'id' => 'ef-may-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-may-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-abr-2021',
                'label' => 'Estados financieros a Abril de 2021',
                'documents' => [
                    [
                        'id' => 'ef-abr-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-abr-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2021',
                'label' => 'Estados financieros a Marzo de 2021',
                'documents' => [
                    [
                        'id' => 'ef-mar-2021-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2021-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2021-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2021-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2020',
                'label' => 'Estados financieros a Diciembre de 2020',
                'documents' => [
                    [
                        'id' => 'ef-dic-2020-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2020-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2020-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2020-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2020',
                'label' => 'Estados financieros a Septiembre de 2020',
                'documents' => [
                    [
                        'id' => 'ef-sep-2020-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2020-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2020-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2020-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2020',
                'label' => 'Estados financieros a Junio de 2020',
                'documents' => [
                    [
                        'id' => 'ef-jun-2020-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2020-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2020-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2020-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2020',
                'label' => 'Estados financieros a Marzo de 2020',
                'documents' => [
                    [
                        'id' => 'ef-mar-2020-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2020-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2020-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2020-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2019',
                'label' => 'Estados financieros a Diciembre de 2019',
                'documents' => [
                    [
                        'id' => 'ef-dic-2019-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2019-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2019-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2019-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2019',
                'label' => 'Estados financieros a Septiembre de 2019',
                'documents' => [
                    [
                        'id' => 'ef-sep-2019-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2019-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2019-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2019-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2019',
                'label' => 'Estados financieros a Junio de 2019',
                'documents' => [
                    [
                        'id' => 'ef-jun-2019-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2019-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2019-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2019-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2019',
                'label' => 'Estados financieros a Marzo de 2019',
                'documents' => [
                    [
                        'id' => 'ef-mar-2019-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2019-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2019-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2019-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2018',
                'label' => 'Estados financieros a Diciembre de 2018',
                'documents' => [
                    [
                        'id' => 'ef-dic-2018-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2018-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2018-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2018-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2018',
                'label' => 'Estados financieros a Septiembre de 2018',
                'documents' => [
                    [
                        'id' => 'ef-sep-2018-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2018-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2018-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2018-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2018',
                'label' => 'Estados financieros a Junio de 2018',
                'documents' => [
                    [
                        'id' => 'ef-jun-2018-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2018-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2018-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2018-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-mar-2018',
                'label' => 'Estados financieros a Marzo de 2018',
                'documents' => [
                    [
                        'id' => 'ef-mar-2018-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2018-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2018-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-mar-2018-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-dic-2017',
                'label' => 'Estados financieros a Diciembre de 2017',
                'documents' => [
                    [
                        'id' => 'ef-dic-2017-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2017-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2017-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-dic-2017-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-sep-2017',
                'label' => 'Estados financieros a Septiembre de 2017',
                'documents' => [
                    [
                        'id' => 'ef-sep-2017-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2017-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2017-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-sep-2017-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'ef-jun-2017',
                'label' => 'Estados financieros a Junio de 2017',
                'documents' => [
                    [
                        'id' => 'ef-jun-2017-res',
                        'url' => '',
                        'title' => 'Estado de resultados',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2017-flujo',
                        'url' => '',
                        'title' => 'Estado de flujo de efectivo',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2017-pat',
                        'url' => '',
                        'title' => 'Estado de cambio en el patrimonio',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'ef-jun-2017-sit',
                        'url' => '',
                        'title' => 'Estado de situación financiera',
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
        'documentColumns' => 1,
    ],
];
