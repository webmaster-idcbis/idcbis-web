<?php

/**
 * Contenido de /atencion-a-usuarios tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'atencion_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Atención y servicio al ciudadano',
        'content' => '',
        'subtitle' => 'Conozca los canales, procedimientos y horarios para presentar peticiones, quejas, reclamos y solicitudes ante el IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'borderRadius' => '1px',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'atencion_peticiones',
        'type' => 'idcbis-links',
        'color' => '#0b4f6c',
        'links' => [
            [
                'id' => 'atencion_link_sdqs',
                'url' => 'https://bogota.gov.co/sdqs',
                'icon' => '🗣️',
                'label' => 'Bogotá Te Escucha',
                'description' => 'Sistema Distrital para la Gestión de Peticiones Ciudadanas. Registre aquí sus peticiones, quejas, reclamos y sugerencias.',
            ],
            [
                'id' => 'atencion_link_registro',
                'url' => 'https://idcbis.org.co/pdf/IDCBIS-ASG-INS-001_REGISTRO_Y_CONSULTA_DE_PETICIONES_EN_BOGOT%C3%81_TE_ESCUCHA.pdf',
                'icon' => '📝',
                'label' => 'Registro y consulta de peticiones en el SDQS',
                'description' => 'Procedimiento para registrar y consultar sus peticiones en Bogotá Te Escucha.',
            ],
            [
                'id' => 'atencion_link_tramite',
                'url' => 'https://idcbis.org.co/pdf/IDCBIS-ASG-INS-001_REGISTRO_Y_CONSULTA_DE_PETICIONES_EN_BOGOT%C3%81_TE_ESCUCHA.pdf',
                'icon' => '📋',
                'label' => 'Recepción, trámite y cierre de peticiones',
                'description' => 'Procedimiento interno de recepción, trámite y cierre de las peticiones ciudadanas.',
            ],
            [
                'id' => 'atencion_link_anonimas',
                'url' => 'https://idcbis.org.co/peticiones-anonimas/',
                'icon' => '🕵️',
                'label' => 'Respuestas a peticiones anónimas',
                'description' => 'Consulte las respuestas publicadas a las peticiones presentadas de forma anónima.',
            ],
        ],
        'fullBleed' => true,
        'blockLabel' => 'Peticiones ciudadanas',
        'cardBorder' => 'none',
        'sectionTitle' => 'Peticiones',
        'cardBoxShadow' => '0 8px 30px rgba(11, 79, 108, 0.08)',
        'cardTextColor' => '#475569',
        'cardBackground' => '#ffffff',
        'cardTitleColor' => '#0b4f6c',
        'highlightColor' => '#2c8c99',
        'backgroundColor' => '#f0f5f8',
        'sectionSubtitle' => 'Sistema de Gestión de Peticiones Ciudadanas Bogotá Te Escucha: procedimientos y canales para radicar y consultar sus solicitudes.',
        'cardBorderRadius' => '20px',
        'sectionHighlight' => 'ciudadanas',
    ],
    [
        'id' => 'atencion_contacto',
        'type' => 'idcbis-contact',
        'items' => [
            [
                'id' => 'atencion_sede',
                'icon' => '📍',
                'text' => 'Carrera 32 No. 12-81, Edificio IDCBIS
Secretaría Distrital de Salud
Bogotá – Colombia',
                'title' => 'Instalaciones',
            ],
            [
                'id' => 'atencion_tel',
                'icon' => '📞',
                'text' => 'PBX (+57) 1 3649620',
                'title' => 'Teléfono',
            ],
            [
                'id' => 'atencion_mail',
                'icon' => '📧',
                'text' => 'contacto@idcbis.org.co',
                'title' => 'Correo electrónico',
            ],
            [
                'id' => 'atencion_judicial',
                'icon' => '⚖️',
                'text' => 'idcbis@idcbis.org.co',
                'title' => 'Notificaciones judiciales',
            ],
        ],
        'fullBleed' => true,
        'blockLabel' => 'Canales de contacto',
    ],
    [
        'id' => 'atencion_cta',
        'type' => 'cta-banner',
        'title' => '¿Tiene una petición, queja o reclamo?',
        'buttons' => [
            [
                'id' => 'atencion_cta_sdqs',
                'url' => 'https://bogota.gov.co/sdqs',
                'icon' => '🗣️',
                'label' => 'Radicar en Bogotá Te Escucha',
                'variant' => 'primary',
            ],
            [
                'id' => 'atencion_cta_contacto',
                'url' => '/contacto',
                'icon' => '✉️',
                'label' => 'Escríbenos',
                'variant' => 'outline',
            ],
        ],
        'subtitle' => 'Su opinión nos ayuda a mejorar. Utilice nuestros canales oficiales y le responderemos dentro de los términos de ley.',
        'fullBleed' => true,
        'blockLabel' => 'Llamado a la acción',
    ],
];
