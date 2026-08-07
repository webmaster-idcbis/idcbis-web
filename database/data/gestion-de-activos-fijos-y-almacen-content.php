<?php

/**
 * Contenido de /gestion-de-activos-fijos-y-almacen.
 * URLs desde C:\laragon\www\transparencia\resources\views\transparencia\gestion_activos_fijos_almacen.blade.php
 */

return [
    [
        'id' => 'activos_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Gestión de activos fijos y almacén',
        'content' => '',
        'subtitle' => "Información pública\nConsulte las actas del comité de inventarios y baja de bienes del IDCBIS.",
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'activos_list',
        'type' => 'idcbis-documents-list',
        'color' => '#000000',
        'groups' => [
            [
                'id' => 'activos-inventarios',
                'label' => 'Acta de comité de inventarios',
                'documents' => [
                    [
                        'id' => 'activos-acta',
                        'url' => 'https://idcbis.org.co/documentos/almacen/Acta%20Comite%20de%20inventarios%20y%20baja%20de%20bienes.pdf',
                        'title' => 'Acta Comite de inventarios y baja de bienes',
                        'publishedAt' => '',
                    ],
                    [
                        'id' => 'activos-anexo1',
                        'url' => 'https://idcbis.org.co/documentos/almacen/Anexo%201.%20Comite%20de%20inventarios.pdf',
                        'title' => 'Anexo 1. Comite de inventarios',
                        'publishedAt' => '',
                    ],
                ],
            ],
        ],
        'layout' => 'sidebar',
        'fullBleed' => true,
        'showSearch' => true,
        'blockLabel' => 'Listado de documentos',
        'documentColumns' => 1,
    ],
];
