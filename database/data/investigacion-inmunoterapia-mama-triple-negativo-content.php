<?php

require_once __DIR__.'/investigacion-inmunoterapia-proyecto.php';

return investigacionInmunoterapiaProyecto([
    'prefix' => 'icmt',
    'title' => 'Mama triple negativo',
    'summary' => 'Caracterización de linfocitos T para una inmunoterapia personalizada en cáncer de mama triple negativo.',
    'image' => '/img/inmunoterapia/espacio-hero.svg',
    'imageAlt' => 'Espacio reservado para una figura de cáncer de mama triple negativo.',
    'content' => "El cáncer de mama triple negativo (CMTN) es uno de los subtipos más difíciles de tratar por la ausencia de las dianas habituales de otros cánceres de mama. Muchas pacientes tienen una respuesta incompleta o recaen. La inmunoterapia con linfocitos infiltrantes de tumor busca usar la capacidad del sistema inmunitario para reconocer y atacar las células tumorales.\n\nEn este proyecto se estudia la respuesta de los TIL frente a neoantígenos generados por alteraciones genéticas propias de cada tumor. A partir de muestras de pacientes se identifican TIL que respondan a neoantígenos específicos, con información genómica y transcriptómica del tumor. La caracterización de célula individual permite ver las poblaciones que participan en el reconocimiento.\n\nDe forma complementaria se desarrolló un flujo para aislar, expandir y caracterizar los TIL: poblaciones de linfocitos T y sus estados de diferenciación, activación y regulación. Así se puede ver cómo la expansión cambia la composición de los TIL y si hay diferencias asociadas a las características clínicas.\n\nLa integración de estas aproximaciones busca conocimiento sobre la respuesta inmunitaria frente al CMTN y una plataforma para identificar TIL con actividad antitumoral de cada paciente.\n\nEl documento reserva tres láminas para esta línea. Esos espacios están a continuación.",
    'after' => [
        [
            'id' => 'icmt_figuras',
            'type' => 'idcbis-services',
            'sectionAnchor' => 'figuras',
            'fullBleed' => true,
            'blockLabel' => 'Figuras pendientes',
            'sectionTitle' => 'Láminas de',
            'sectionHighlight' => 'mama triple negativo',
            'sectionSubtitle' => 'El documento trae tres diapositivas solo con el título. Cada recuadro espera su imagen.',
            'cards' => [
                [
                    'id' => 'icmt_fig_1',
                    'title' => 'Lámina 1',
                    'description' => 'Espacio reservado. Información pendiente.',
                    'image' => '',
                    'imageAlt' => 'Espacio reservado para la primera lámina de cáncer de mama triple negativo.',
                    'tag' => 'Imagen pendiente',
                    'url' => '#figuras',
                    'bgColor' => '#ffffff',
                ],
                [
                    'id' => 'icmt_fig_2',
                    'title' => 'Lámina 2',
                    'description' => 'Espacio reservado. Información pendiente.',
                    'image' => '',
                    'imageAlt' => 'Espacio reservado para la segunda lámina de cáncer de mama triple negativo.',
                    'tag' => 'Imagen pendiente',
                    'url' => '#figuras',
                    'bgColor' => '#ffffff',
                ],
                [
                    'id' => 'icmt_fig_3',
                    'title' => 'Lámina 3',
                    'description' => 'Espacio reservado. Información pendiente.',
                    'image' => '',
                    'imageAlt' => 'Espacio reservado para la tercera lámina de cáncer de mama triple negativo.',
                    'tag' => 'Imagen pendiente',
                    'url' => '#figuras',
                    'bgColor' => '#ffffff',
                ],
            ],
        ],
    ],
]);
