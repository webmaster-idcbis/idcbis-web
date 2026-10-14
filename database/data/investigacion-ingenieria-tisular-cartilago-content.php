<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-linea.php';

$imagen = ingenieriaTisularImagen();

return investigacionIngenieriaTisularLinea([
    'prefix' => 'itc',
    'title' => 'Cartílago',
    'summary' => 'Alternativas para la reparación de tejidos cartilaginosos y osteocondrales.',
    'content' => "Esta línea reúne diferentes proyectos enfocados en el desarrollo de alternativas para la reparación de defectos condrales y osteocondrales mediante el uso de biomateriales y distintas tecnologías de fabricación. Se emplean técnicas como la impresión tridimensional (3D), el electrohilado y la formulación de hidrogeles, tanto de manera independiente como combinada, para obtener estructuras con características específicas según el tejido y la aplicación prevista. Estas estrategias permiten investigar diferentes configuraciones, composiciones y propiedades de los materiales, considerando las particularidades del cartílago articular y su interacción con el tejido óseo subcondral. Los desarrollos incluyen procesos de caracterización y evaluación experimental orientados a determinar su potencial como alternativas para la reparación de lesiones articulares.",
    'cards' => [
        [
            'id' => 'itc_p1',
            'title' => 'Dispositivos médicos osteocondrales',
            'description' => 'Impresión 3D de PLA con hidrogel de alginato de calcio. Dispositivos BOTÓN y OAT.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen de los dispositivos osteocondrales.',
            'tag' => 'Abrir ficha',
            'url' => '/investigacion-ingenieria-tisular-dispositivos-osteocondrales',
            'bgColor' => '#ffffff',
        ],
        [
            'id' => 'itc_p2',
            'title' => 'Impresión 3D de PCL con hidrogel de PVA/LP',
            'description' => 'Proyecto nombrado en la línea. Su desarrollo científico aún no está en el documento.',
            'image' => $imagen,
            'imageAlt' => 'Espacio reservado para la imagen del proyecto de PCL con hidrogel de PVA/LP.',
            'tag' => 'Ficha en preparación',
            'url' => '/investigacion-ingenieria-tisular-pcl-pva',
            'bgColor' => '#ffffff',
        ],
    ],
]);
