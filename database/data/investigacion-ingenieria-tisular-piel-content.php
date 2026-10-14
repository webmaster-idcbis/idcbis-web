<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-linea.php';

$imagen = ingenieriaTisularImagen();

return investigacionIngenieriaTisularLinea([
    'prefix' => 'itp',
    'title' => 'Piel',
    'summary' => 'Biomateriales y sustitutos cutáneos para el tratamiento de lesiones de la piel.',
    'content' => "Esta línea comprende diferentes proyectos orientados al desarrollo de biomateriales y sustitutos cutáneos mediante diversas estrategias de procesamiento y fabricación. Entre ellas se encuentra la obtención de dermis descelularizada a través de métodos enzimáticos, físicos y químicos, con el propósito de conservar una matriz extracelular que pueda ser utilizada como soporte biológico. Paralelamente, se desarrollan membranas electrohiladas a partir de biomateriales para aplicaciones en reparación cutánea, así como formulaciones de hidrogeles destinadas a la elaboración de apósitos y otras alternativas para el tratamiento de lesiones de la piel. Estas aproximaciones permiten explorar materiales con distintas propiedades estructurales, fisicoquímicas y biológicas, de acuerdo con las necesidades de cada aplicación.",
    'cards' => [
        [
            'id' => 'itp_p1',
            'title' => 'MatriAcel',
            'description' => 'Dermis acelular de origen humano para ingeniería de tejidos y reparación cutánea.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de MatriAcel.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-matriacel',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'itp_p2',
            'title' => 'PCEM-TGPiel',
            'description' => 'Membrana electrohilada de PCL/COL con evaluación preclínica.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de PCEM-TGPiel.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-pcem-tgpiel',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'itp_p3',
            'title' => 'Fibroglic',
            'description' => 'Membrana electrohilada de PCL funcionalizada con glicina.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de Fibroglic.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-fibroglic',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'itp_p4',
            'title' => 'Hyalovite',
            'description' => 'Apósito de hidrogel a base de alcohol polivinílico.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de Hyalovite.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-hyalovite',
            'bgColor' => '#ffffff',
        ],
    ],
]);
