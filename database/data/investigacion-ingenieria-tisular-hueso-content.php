<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-linea.php';

$imagen = ingenieriaTisularImagen();

return investigacionIngenieriaTisularLinea([
    'prefix' => 'ith',
    'title' => 'Hueso',
    'summary' => 'Desarrollo y evaluación de biomateriales y estructuras tridimensionales para la reparación de defectos óseos.',
    'content' => "Esta línea se enfoca en el desarrollo y evaluación de un sustituto óseo que integra dos técnicas de fabricación en un mismo dispositivo: impresión tridimensional (3D) y electrohilado. Mediante la combinación de estas tecnologías, se busca obtener una estructura que reúna las propiedades mecánicas de un soporte tridimensional con las características superficiales proporcionadas por un recubrimiento de fibras electrohiladas. El proyecto contempla la caracterización fisicoquímica, mecánica y biológica del dispositivo, así como la evaluación de su comportamiento en modelos experimentales, con el propósito de desarrollar una alternativa basada en biomateriales para la reparación de defectos óseos.",
    'cards' => [
        [
            'id' => 'ith_p1',
            'title' => '3D QUYNE',
            'description' => 'Dispositivo médico impreso en 3D en PLA con recubrimiento electrohilado de PLA/FCA.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de 3D QUYNE.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-3d-quyne',
            'bgColor' => '#ffffff',
        ],
    ],
]);
