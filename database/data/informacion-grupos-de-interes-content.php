<?php

/**
 * Contenido de /informacion-grupos-de-interes tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'grupos_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Información específica para grupos de interés',
        'content' => '',
        'subtitle' => 'Recursos e información dirigida a niños, niñas, adolescentes y mujeres.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'grupos_intro',
        'type' => 'text',
        'color' => '#4b5563',
        'margin' => '2rem auto',
        'content' => 'El IDCBIS publica información y materiales educativos orientados a grupos de interés específicos, en el marco de la transparencia y el acceso a la información pública.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '720px',
        'fullBleed' => false,
        'textAlign' => 'center',
        'blockLabel' => 'Introducción',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'grupos_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'grupos-nna',
                'label' => 'Información para niños, niñas y adolescentes',
                'documents' => [
                    [
                        'id' => 'grupos-nna-1',
                        'url' => 'https://idcbis.org.co/documentos/datos/cartilla_digital_trasarte.pdf',
                        'title' => 'Diario de acompañamiento al trasplante de médula ósea',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'grupos-nna-2',
                        'url' => 'https://www.youtube.com/watch?v=8cUjUQdILPI',
                        'title' => 'La Sangre y su recorrido por la vida',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'grupos-nna-3',
                        'url' => 'https://idcbis.org.co/documentos/datos/Infografia%20Ruta%20del%20trasplante.pdf',
                        'title' => 'Ruta del trasplante',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'grupos-nna-4',
                        'url' => 'https://idcbis.org.co/documentos/datos/Folleto%20padres%20v9.pdf',
                        'title' => 'Padres ¿Por qué vale la pena intentarlo?',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'grupos-nna-5',
                        'url' => 'https://www.youtube.com/watch?v=CBH8uOl3xKM',
                        'title' => 'Hacemos ciencia con tu donación',
                        'publishedAt' => '',
                    ],
                ],
            ],
            [
                'id' => 'grupos-mujeres',
                'label' => 'Información para mujeres',
                'documents' => [
                    [
                        'id' => 'grupos-muj-1',
                        'url' => '/banco-publico-sangre-cordon-umbilical',
                        'title' => 'Programa de Captación Cordial',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'grupos-muj-2',
                        'url' => 'https://idcbis.org.co/documentos/datos/Procesamos_Tejidos.pdf',
                        'title' => 'Donación de tejidos',
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
