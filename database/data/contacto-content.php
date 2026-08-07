<?php

/**
 * Contenido de /contacto tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'contacto_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Contáctenos',
        'content' => '',
        'subtitle' => 'Estamos para atender sus consultas, solicitudes y comentarios sobre los servicios del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '260px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'borderRadius' => '1px',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'contacto_form',
        'type' => 'form',
        'title' => 'Escríbenos',
        'fields' => [
            [
                'name' => 'nombre',
                'type' => 'text',
                'label' => 'Nombre completo',
                'required' => true,
                'placeholder' => 'Ingrese su nombre',
            ],
            [
                'name' => 'email',
                'type' => 'email',
                'label' => 'Correo electrónico',
                'required' => true,
                'placeholder' => 'correo@ejemplo.com',
            ],
            [
                'name' => 'asunto',
                'type' => 'text',
                'label' => 'Asunto',
                'required' => true,
                'placeholder' => 'Motivo de su consulta',
            ],
            [
                'name' => 'mensaje',
                'rows' => 5,
                'type' => 'textarea',
                'label' => 'Mensaje',
                'required' => true,
                'placeholder' => 'Escriba su mensaje aquí',
            ],
        ],
        'padding' => '2rem',
        'blockLabel' => 'Formulario',
        'description' => 'Complete el formulario y nos pondremos en contacto con usted a la brevedad posible.',
        'submitLabel' => 'Enviar mensaje',
        'borderRadius' => '12px',
        'backgroundColor' => '#ffffff',
    ],
    [
        'id' => 'contacto_info',
        'type' => 'idcbis-contact',
        'items' => [
            [
                'id' => 'contacto_sede',
                'icon' => '📍',
                'text' => 'Carrera 32 #12-81
Bogotá D.C., Colombia',
                'title' => 'Sede principal',
            ],
            [
                'id' => 'contacto_tel',
                'icon' => '📞',
                'text' => 'PBX (+57) 1 3649620',
                'title' => 'Teléfono',
            ],
            [
                'id' => 'contacto_mail',
                'icon' => '📧',
                'text' => 'contacto@idcbis.org.co',
                'title' => 'Correo electrónico',
            ],
            [
                'id' => 'contacto_horario',
                'icon' => '🕐',
                'text' => 'Lunes a viernes
7:30 a.m. – 4:30 p.m.',
                'title' => 'Horario de atención',
            ],
        ],
        'fullBleed' => true,
        'blockLabel' => 'Datos de contacto',
    ],
];
