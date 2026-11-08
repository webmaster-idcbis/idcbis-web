<?php

/**
 * Portal /donaciones: elige donación de sangre o de tejidos
 * y continúa a la página de cada servicio.
 */

return [
    [
        'id' => 'donaciones_hub',
        'type' => 'idcbis-donations-hub',
        'fullBleed' => true,
        'blockLabel' => 'Portal de donaciones',
        'eyebrow' => 'Un acto que nace de ti',
        'title' => 'Elige cómo regalar vida',
        'subtitle' => 'Donar sangre o tejidos es voluntario, gratuito y altruista. Elige un camino y conoce qué significa tu decisión para otras personas.',
        'valuesTitle' => 'Así entendemos la donación',
        'paths' => [
            [
                'id' => 'donacion_sangre',
                'tone' => 'sangre',
                'kicker' => '01 · Sangre',
                'title' => 'Donar sangre',
                'description' => 'En cerca de 15 minutos puedes ayudar a salvar hasta 3 vidas. Tu sangre se separa en componentes para varios pacientes de Bogotá.',
                'facts' => ['15 minutos', 'Hasta 3 vidas', 'Donación segura'],
                'cta' => 'Conocer la donación de sangre',
                'url' => '/banco-de-sangre',
                'image' => '/img/Servicios Home/BS-1200x800.png',
            ],
            [
                'id' => 'donacion_tejidos',
                'tone' => 'tejidos',
                'kicker' => '02 · Tejidos',
                'title' => 'Donar tejidos',
                'description' => 'Una donación de tejidos puede mejorar, y en muchos casos salvar, la vida de decenas de pacientes. Expresa tu voluntad y háblalo con tu familia.',
                'facts' => ['En vida o después', '#déjalo conversado', 'Decenas de pacientes'],
                'cta' => 'Conocer la donación de tejidos',
                'url' => '/banco-distrital-de-tejidos#donacion',
                'image' => '/img/Servicios Home/BT-1200x800.png',
            ],
        ],
        'values' => [
            [
                'id' => 'valor_voluntaria',
                'title' => 'Voluntaria',
                'text' => 'La decisión es tuya. Nadie puede obligarte a donar.',
            ],
            [
                'id' => 'valor_gratuita',
                'title' => 'Gratuita',
                'text' => 'Donar no tiene costo ni retribución económica.',
            ],
            [
                'id' => 'valor_solidaria',
                'title' => 'Solidaria',
                'text' => 'Ayudas a alguien que quizá nunca vas a conocer.',
            ],
            [
                'id' => 'valor_segura',
                'title' => 'Segura',
                'text' => 'El IDCBIS cuida a quien dona y a quien recibe.',
            ],
        ],
    ],
];
