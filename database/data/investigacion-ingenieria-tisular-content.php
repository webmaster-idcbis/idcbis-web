<?php

require_once __DIR__.'/investigacion-ingenieria-tisular-bloques.php';

/**
 * /investigacion-ingenieria-tisular
 * Portada de la Unidad de Ingeniería Tisular, según el wireframe UIT.
 * Cuatro líneas visibles; el resto de tarjetas entra con las flechas.
 */

$imagen = ingenieriaTisularImagen();

return [
    ingenieriaTisularHero(
        'it_hero',
        'Ingeniería de tejidos',
        'Unidad de Ingeniería Tisular. Conoce nuestras líneas de investigación.',
        'Ver las líneas',
        '#lineas'
    ),
    [
        'id' => 'it_lineas',
        'type' => 'idcbis-expanding-cards',
        'anchorId' => 'lineas',
        'fullBleed' => true,
        'blockLabel' => 'Líneas de investigación',
        'sectionTitle' => 'Líneas de investigación',
        'sectionSubtitle' => 'En pantalla grande se ven cuatro tarjetas. La activa se amplía y muestra su descripción. En el celular, toque una tarjeta para leerla y luego ábrala.',
        'visibleCount' => 4,
        'cards' => [
            [
                'id' => 'it_hueso',
                'kicker' => 'Línea',
                'title' => 'Hueso',
                'description' => 'Desarrollo y evaluación de biomateriales y estructuras tridimensionales para aplicaciones en reparación de defectos óseos.',
                'linkText' => 'Abrir hueso',
                'url' => '/investigacion-ingenieria-tisular-hueso',
                'image' => $imagen,
                'accent' => '#003C5F',
            ],
            [
                'id' => 'it_piel',
                'kicker' => 'Línea',
                'title' => 'Piel',
                'description' => 'Investigación y desarrollo de sustitutos cutáneos mediante diferentes biomateriales y estrategias de fabricación para el tratamiento de lesiones de la piel.',
                'linkText' => 'Abrir piel',
                'url' => '/investigacion-ingenieria-tisular-piel',
                'image' => $imagen,
                'accent' => '#005674',
            ],
            [
                'id' => 'it_cartilago',
                'kicker' => 'Línea',
                'title' => 'Cartílago',
                'description' => 'Desarrollo de alternativas para la reparación de tejidos cartilaginosos y osteocondrales mediante el uso de biomateriales y diversas técnicas de fabricación.',
                'linkText' => 'Abrir cartílago',
                'url' => '/investigacion-ingenieria-tisular-cartilago',
                'image' => $imagen,
                'accent' => '#0B4F6C',
            ],
            [
                'id' => 'it_otras',
                'kicker' => 'Línea',
                'title' => 'Otras líneas de investigación',
                'description' => 'Exploramos nuevas líneas de investigación orientadas al desarrollo de biomateriales, matrices biológicas y soluciones innovadoras para diversas aplicaciones biomédicas y cosméticas.',
                'linkText' => 'Abrir otras líneas',
                'url' => '/investigacion-ingenieria-tisular-otras',
                'image' => $imagen,
                'accent' => '#008996',
            ],
            [
                'id' => 'it_nav_equipo',
                'kicker' => 'Unidad',
                'title' => 'Integrantes de la UIT',
                'description' => 'Equipo multidisciplinar que integra diversas áreas del conocimiento para impulsar la investigación y el desarrollo en ingeniería de tejidos.',
                'linkText' => 'Ir al equipo',
                'url' => '#equipo',
                'image' => $imagen,
                'accent' => '#003C5F',
            ],
            [
                'id' => 'it_nav_reconocimientos',
                'kicker' => 'Unidad',
                'title' => 'Publicaciones y reconocimientos',
                'description' => 'Premios y reconocimientos del trabajo de la Unidad de Ingeniería Tisular.',
                'linkText' => 'Ir a reconocimientos',
                'url' => '#reconocimientos',
                'image' => $imagen,
                'accent' => '#005674',
            ],
        ],
    ],
    [
        'id' => 'it_equipo',
        'type' => 'idcbis-team-grid',
        'anchorId' => 'equipo',
        'fullBleed' => true,
        'blockLabel' => 'Integrantes',
        'sectionTitle' => 'Integrantes de la UIT',
        'sectionSubtitle' => 'Equipo multidisciplinar que integra diversas áreas del conocimiento para impulsar la investigación y el desarrollo en ingeniería de tejidos.',
        'members' => [
            [
                'id' => 'it_m1',
                'name' => 'Ingrid Silva',
                'role' => 'Líder en investigación de ingeniería de tejidos',
                'credentials' => 'Bacterióloga. MSc. Ph.D.',
                'email' => 'izsilva@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m2',
                'name' => 'Adriana Lorena Lara Bertrand',
                'role' => 'Investigadora',
                'credentials' => 'Diseñadora industrial. Esp. MSc.',
                'email' => 'alara@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m3',
                'name' => 'Leonardo Prieto',
                'role' => 'Investigador',
                'credentials' => 'Ingeniero químico, M. Eng.',
                'email' => 'lprieto@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m4',
                'name' => 'Víctor M. Duarte',
                'role' => 'Investigador',
                'credentials' => 'Microbiólogo industrial, MSc.',
                'email' => '',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m5',
                'name' => 'Andrea Lizarazo',
                'role' => 'Investigadora',
                'credentials' => 'Química, MSc.',
                'email' => 'alizarazo@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m6',
                'name' => 'William Cárdenas',
                'role' => 'Investigador',
                'credentials' => 'Químico, M. Eng.',
                'email' => 'wcardenas@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
            [
                'id' => 'it_m7',
                'name' => 'Laura Paipa Zambrano',
                'role' => 'Investigadora',
                'credentials' => 'Ingeniera industrial',
                'email' => 'lipaipa@idcbis.org.co',
                'image' => '',
                'photoSlug' => '',
            ],
        ],
    ],
    [
        'id' => 'it_reconocimientos',
        'type' => 'idcbis-card-grid',
        'anchorId' => 'reconocimientos',
        'fullBleed' => true,
        'columns' => 3,
        'backgroundColor' => '#f5f8fa',
        'blockLabel' => 'Reconocimientos',
        'title' => 'Publicaciones y reconocimientos',
        'subtitle' => 'Reconocimientos de la unidad. El año se muestra cuando el documento lo indica.',
        'items' => [
            [
                'id' => 'it_r1',
                'title' => 'Premio ANDI',
                'description' => 'Invenciones que transforman la salud en dispositivos médicos. 2026.',
            ],
            [
                'id' => 'it_r2',
                'title' => '2600 Campus',
                'description' => 'Reconocimiento 2025.',
            ],
            [
                'id' => 'it_r3',
                'title' => 'Crearlo no es suficiente',
                'description' => 'Reconocimiento 2022.',
            ],
            [
                'id' => 'it_r4',
                'title' => 'Negocios verdes',
                'description' => 'Reconocimiento de la unidad.',
            ],
            [
                'id' => 'it_r5',
                'title' => 'Sácale jugo a tu patente',
                'description' => 'Reconocimiento de la unidad.',
            ],
            [
                'id' => 'it_r6',
                'title' => 'Mención de honor en el SID 13',
                'description' => 'México, 2021.',
            ],
        ],
    ],
    ingenieriaTisularCta(
        'it_cta',
        'Unidad de Terapias Avanzadas',
        'Regrese a las líneas de la unidad.',
        [
            [
                'id' => 'it_cta_back',
                'url' => '/investigacion-terapias-avanzadas',
                'icon' => '←',
                'label' => 'Volver a la unidad',
                'variant' => 'primary',
            ],
        ]
    ),
];
