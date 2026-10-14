<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-linea.php';

$imagen = ingenieriaTisularImagen();

return investigacionIngenieriaTisularLinea([
    'prefix' => 'ito',
    'title' => 'Otras líneas de investigación',
    'summary' => 'Biomateriales, matrices biológicas y plataformas para otras aplicaciones biomédicas.',
    'content' => "Exploramos nuevas líneas de investigación orientadas al desarrollo de biomateriales, matrices biológicas y soluciones innovadoras para diversas aplicaciones biomédicas y cosméticas.\n\nAquí se reúnen las investigaciones de la unidad que no forman parte de hueso, piel ni cartílago: vesículas extracelulares, progenitores hematopoyéticos en matrices biomiméticas e ingeniería de tejido vascular.",
    'cards' => [
        [
            'id' => 'ito_p1',
            'title' => 'Vesículas extracelulares',
            'description' => 'Aislamiento y caracterización de vesículas derivadas de células estromales mesenquimales de gelatina de Wharton.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de vesículas extracelulares.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-vesiculas-extracelulares',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'ito_p2',
            'title' => 'Progenitores hematopoyéticos',
            'description' => 'Progenitores de sangre de cordón umbilical en matrices biomiméticas.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de progenitores hematopoyéticos.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-progenitores-hematopoyeticos',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'ito_p3',
            'title' => 'Tejido vascular',
            'description' => 'Andamio biosintético tubular para reparación de tejido vascular.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de ingeniería de tejido vascular.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-tejido-vascular',
            'bgColor' => '#ffffff',
        ],
    ],
]);
