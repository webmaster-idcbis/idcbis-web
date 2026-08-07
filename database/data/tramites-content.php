<?php

/**
 * Contenido de /tramites tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'tramites_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Trámites',
        'content' => '',
        'subtitle' => 'Información sobre trámites y Otros Procedimientos Administrativos (OPAs) del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'tramites_texto',
        'type' => 'text',
        'color' => '#334155',
        'margin' => '2rem auto',
        'content' => 'Dadas las funciones del IDCBIS, la relación con los ciudadanos es indirecta e inversa, ya que no procede un acceso directo de los ciudadanos a los servicios ofertados por el IDCBIS. El suministro de hemocomponentes, tejidos y otros, se materializa a través de contratos suscritos con los hospitales de la red pública o clínicas del sector privado. Por lo anterior, no se cuenta con trámites, requisitos o permisos expresamente autorizados por la Ley que afecten a los ciudadanos y que conlleven a que el IDCBIS construya trámites u Otros Procedimientos Administrativos – OPAs-. Lo anterior, fue confirmado en concepto emitido por el Departamento Administrativo de la Función Pública de fecha 13 de agosto de 2019.',
        'padding' => '0 24px',
        'fontSize' => '17px',
        'maxWidth' => '800px',
        'fullBleed' => false,
        'textAlign' => 'left',
        'blockLabel' => 'Contenido',
        'lineHeight' => '1.65',
    ],
    [
        'id' => 'tramites_cta',
        'type' => 'cta-banner',
        'title' => '¿Tiene una solicitud o consulta?',
        'buttons' => [
            [
                'id' => 'tramites_cta_atencion',
                'url' => '/atencion-a-usuarios',
                'icon' => '/img/Iconos/contacto.svg',
                'label' => 'Atención a usuarios',
                'variant' => 'primary',
            ],
            [
                'id' => 'tramites_cta_contacto',
                'url' => '/contacto',
                'icon' => '/img/Iconos/correo.svg',
                'label' => 'Contáctenos',
                'variant' => 'outline',
            ],
        ],
        'subtitle' => 'Utilice los canales oficiales de atención al ciudadano para radicar peticiones o solicitar información.',
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
    ],
];
