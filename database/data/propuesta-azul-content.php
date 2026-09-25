<?php

/**
 * Contenido de /inicio tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'hero_carousel_inicio',
        'type' => 'idcbis-hero-carousel',
        'color' => '#000000',
        'slides' => [
            [
                'id' => 'slide_inicio_home',
                'subtitle' => 'En el IDCBIS convertimos ciencia, innovación y capacidades especializadas en soluciones para la salud y la vida de los colombianos.',
                'titleBold' => 'transforma vidas',
                'titleLight' => 'Ciencia que',
                'button1Text' => 'Quiero donar sangre',
                'button1Url' => '/banco-de-sangre',
                'button2Text' => 'Registrarme en DarCélulas',
                'button2Url' => '/darcelulas',
                'button3Text' => 'Conocer nuestros servicios',
                'button3Url' => '#servicios',
                'imageAlt' => '',
                'backgroundImage' => '',
            ],
        ],
        'quickAnswers' => [
            [
                'id' => 'qa_que_es',
                'icon' => 'institute',
                'question' => '¿Qué es IDCBIS?',
                'answer' => 'Un Instituto de ciencia, biotecnología e innovación en salud.',
            ],
            [
                'id' => 'qa_que_hacemos',
                'icon' => 'science',
                'question' => '¿Qué hacemos?',
                'answer' => 'Convertimos ciencia e innovación en soluciones para la salud y la vida.',
            ],
            [
                'id' => 'qa_que_puedes',
                'icon' => 'action',
                'question' => '¿Qué puedes hacer aquí?',
                'answer' => 'Donar, registrarme, conocer servicios, investigar, estudiar o generar alianzas.',
            ],
        ],
        'visualFrames' => [
            [
                'src' => '/img/Banners WEB/Baner-Pagina-WEB-1920x700-BS.jpg',
                'alt' => 'Profesional del Banco Distrital de Sangre procesando un componente sanguíneo',
            ],
            [
                'src' => '/img/Banners WEB/Baner-Pagina-WEB-1920x700-TA.jpg',
                'alt' => 'Científica del IDCBIS en el laboratorio de terapias avanzadas',
            ],
            [
                'src' => '/img/Banners WEB/Baner-Pagina-WEB-1920x700-DC.jpg',
                'alt' => 'Manos sosteniendo una célula, la ciencia al servicio de la vida',
            ],
        ],
        'videoSrc' => '',
        'videoPoster' => '/img/Banners WEB/Baner-Pagina-WEB-1920x700-BS.jpg',
        'videoLabel' => 'Secuencia del IDCBIS: de la donación al laboratorio y a la vida',
        'frameInterval' => 4500,
        'content' => '',
        'autoPlay' => false,
        'fontSize' => '16px',
        'interval' => 5000,
        'fullBleed' => true,
        'blockLabel' => 'Hero principal (carrusel)',
        'showArrows' => false,
        'showIndicators' => false,
        'backgroundImage' => '',
    ],
    [
        'id' => 'idcbis_services_inicio',
        'type' => 'idcbis-services',
        'cards' => [
            [
                'id' => 'card_sangre',
                'tag' => '#DONARVIDA',
                'url' => '/banco-de-sangre',
                'image' => '/img/Servicios%20Home/BS-1200x800.png',
                'title' => 'Banco Distrital de Sangre',
                'description' => 'Es rápida, segura y salva hasta 3 vidas. Necesitamos todos los grupos sanguíneos.',
            ],
            [
                'id' => 'card_cordon',
                'tag' => '#FUTURO',
                'url' => '/banco-publico-sangre-cordon-umbilical',
                'image' => '/img/Servicios%20Home/B-Cordon-1200x800.png',
                'title' => 'Sangre de Cordón umbilical',
                'description' => 'Las células del cordón son un tesoro. Ayudan a pacientes pediátricos con enfermedades graves.',
            ],
            [
                'id' => 'card_tejidos',
                'tag' => '#REGALAVIDA',
                'url' => '/banco-distrital-de-tejidos',
                'image' => '/img/Servicios%20Home/BT-1200x800.png',
                'title' => 'Banco Distrital de Tejidos',
                'description' => 'Piel, huesos, córneas... Tu donación puede devolver la vista o la movilidad a alguien.',
            ],
            [
                'id' => 'card_terapias',
                'tag' => '#INNOVACIÓN',
                'url' => '/unidad-de-terapias-avanzadas',
                'image' => '/img/Servicios%20Home/TE-AV-1200x800.png',
                'title' => 'Terapias avanzadas',
                'description' => 'Tratamos enfermedades autoinmunes con células. Somos pioneros en Latinoamérica.',
            ],
            [
                'id' => 'card_donantes',
                'tag' => '#SANGREUNICA',
                'url' => '/darcelulas',
                'image' => '/img/Servicios%20Home/DC-1200x800.png',
                'title' => 'Registro Nacional de donantes',
                'description' => '¿Tienes sangre rara? Tu tipo puede ser clave para alguien. Inscribite.',
            ],
            [
                'id' => 'card_bienestar',
                'tag' => '#SENTIRSEBIEN',
                'url' => '/atencion-a-usuarios',
                'image' => '/img/Servicios%20Home/Bienestar-Charlas-Investigacion-1200x800.png',
                'title' => 'Bienestar',
                'description' => 'Charlas, hábitos, comunidad. Porque la salud también es prevenir.',
            ],
        ],
        'color' => '#000000',
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Grid de servicios',
        'sectionAnchor' => 'servicios',
        'sectionTitle' => 'Nuestros',
        'sectionSubtitle' => 'Elige el que más se adapte a ti. Todos son importantes.',
        'sectionHighlight' => 'servicios',
    ],
    [
        'id' => 'idcbis_audiences_inicio',
        'type' => 'idcbis-audiences',
        'color' => '#000000',
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Accesos según tu perfil',
        'sectionTitle' => 'Encuentra lo que necesitas según tu perfil',
        'sectionSubtitle' => 'Cada persona tiene una razón para visitarnos. Te ayudamos a llegar más rápido.',
        // Cada url es una página ya publicada. No hay landings propias de estudiante ni de aliado.
        'cards' => [
            [
                'id' => 'audience_ciudadano',
                'icon' => 'users',
                'title' => 'Soy Ciudadano',
                'description' => 'Información, campañas, participación y contacto.',
                'url' => '/participa',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_donante',
                'icon' => 'droplet',
                'title' => 'Soy Donante',
                'description' => 'Donación de sangre, tejidos y registro en DarCélulas.',
                // No hay una sola página de donante. El acceso principal publicado es el banco de sangre.
                'url' => '/banco-de-sangre',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_paciente',
                'icon' => 'patient',
                'title' => 'Soy Paciente o Familiar',
                'description' => 'Servicios, orientación y contactos.',
                'url' => '/atencion-a-usuarios',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_profesional',
                'icon' => 'stethoscope',
                'title' => 'Soy Profesional de la Salud',
                'description' => 'Servicios especializados, investigación y contacto.',
                // No hay un hub único para profesionales. Terapias avanzadas es el servicio especializado publicado.
                'url' => '/unidad-de-terapias-avanzadas',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_investigador',
                'icon' => 'flask',
                'title' => 'Soy Investigador',
                'description' => 'Proyectos, grupos, publicaciones y alianzas.',
                'url' => '/investigacion',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_estudiante',
                'icon' => 'student',
                'title' => 'Soy Estudiante',
                'description' => 'Prácticas, investigación, convocatorias y contacto.',
                // No hay página de prácticas o convocatorias. El destino temporal es contacto.
                'url' => '/contacto',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_aliado',
                'icon' => 'handshake',
                'title' => 'Soy Aliado',
                'description' => 'Cooperación, alianzas y posibilidades de apoyo.',
                // No hay página de alianzas publicada. El destino temporal es contacto.
                'url' => '/contacto',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_periodista',
                'icon' => 'news',
                'title' => 'Soy Periodista',
                'description' => 'Noticias, voceros y contacto de Comunicaciones.',
                // No hay sala de prensa. El destino publicado es el listado de noticias.
                'url' => '/noticias',
                'linkText' => 'Ir a mi sección',
            ],
            [
                'id' => 'audience_proveedor',
                'icon' => 'briefcase',
                'title' => 'Soy Proveedor',
                'description' => 'Contratación y procesos correspondientes.',
                'url' => '/contratacion',
                'linkText' => 'Ir a mi sección',
            ],
        ],
    ],
    [
        'id' => 'idcbis_stats_inicio',
        'type' => 'idcbis-stats',
        'color' => '#000000',
        'items' => [
            // Cifras ya publicadas en el home. No se añaden datos nuevos.
            [
                'id' => 'stat_sangre',
                'icon' => 'droplet',
                'label' => 'donaciones al año',
                'caption' => 'Cada gota cuenta.',
                'value' => '+3.000',
            ],
            [
                'id' => 'stat_investigadores',
                'icon' => 'users',
                'label' => 'investigadores trabajando por la salud de Colombia',
                'caption' => 'Ciencia con propósito.',
                'value' => '150',
            ],
            [
                'id' => 'stat_bogota',
                'icon' => 'award',
                'label' => 'en Bogotá',
                'caption' => 'Reconocimiento que nos compromete.',
                'value' => '#1',
            ],
            // Pendiente de fuente. No publicar hasta que el equipo confirme la cifra:
            // '+10.000' pacientes beneficiados con terapias avanzadas / 'Vidas transformadas.'
            // '#1 en Bogotá en medicina transfusional' (hoy solo está publicado "#1 en Bogotá")
            // DarCélulas: personas inscritas en el registro — sin dato en el sitio
            // Banco de Tejidos: pacientes o injertos — sin dato en el sitio
            // '12 programas' estaba en esta franja; se retira hasta confirmar si sigue vigente
        ],
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Cifras destacadas',
        'backgroundColor' => '#C4A140',
    ],
    [
        'id' => 'idcbis_bubbles_inicio',
        'type' => 'idcbis-bubbles',
        'color' => '#000000',
        'cardColor' => '#0B4F6C',
        'items' => [
            [
                'id' => 'bubble_1',
                'title' => 'Registro Nacional',
                'description' => 'Donantes de células hematopoyéticas.',
            ],
            [
                'id' => 'bubble_2',
                'title' => 'Medicina Transfusional',
                'description' => 'Reconocido por MinCiencias.',
            ],
            [
                'id' => 'bubble_3',
                'title' => 'Ingeniería Tisular',
                'description' => 'Medicina regenerativa.',
            ],
            [
                'id' => 'bubble_4',
                'title' => 'Medicina de Laboratorio',
                'description' => 'Estándares internacionales.',
            ],
        ],
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Programas de investigación',
        'sectionTitle' => 'Programas de',
        'sectionHighlight' => 'investigación',
    ],
    [
        'id' => 'idcbis_about_inicio',
        'type' => 'idcbis-about',
        'color' => '#000000',
        'variant' => 'clean',
        'image' => '/img/Servicios%20Home/BS-B-1200x800.png',
        'title' => 'Somos IDCBIS',
        'content' => 'En el IDCBIS, la ciencia no se queda en el laboratorio. Cada día, un equipo de 150 investigadores trabaja para convertir descubrimientos científicos en soluciones reales para los colombianos.

Desde un banco de sangre hasta una terapia CAR-T, nuestro trabajo tiene un solo propósito: mejorar la vida de las personas.

Somos un Instituto Distrital reconocido por MinCiencias, pero sobre todo, somos las personas detrás de cada avance.',
        'quote' => 'Trabajo aquí porque cada muestra que procesamos puede salvar una vida.',
        // No atribuir este testimonio hasta confirmar persona y cargo. No inventar el nombre.
        'quoteAuthor' => '',
        'quoteRole' => '',
        'buttonText' => 'Conoce a nuestro equipo',
        'buttonUrl' => '/quienes-somos#equipo',
        'fontSize' => '16px',
        'imageAlt' => 'Equipo de aféresis y componentes sanguíneos del Banco Distrital de Sangre',
        'fullBleed' => true,
        'blockLabel' => 'Somos IDCBIS',
    ],
    [
        'id' => 'portal_bogota_inicio',
        'type' => 'html',
        'blockLabel' => 'Qué está pasando en Bogotá',
        'htmlCode' => '<section id="portal-bogota-block" data-cat="Salud"></section><script src="https://bogota.gov.co/2025/queestapasando/main-block.js"></script>',
        'padding' => '2.5rem 0',
        'width' => '100%',
        'fullBleed' => true,
    ],
    [
        'id' => 'idcbis_contact_inicio',
        'type' => 'idcbis-contact',
        'color' => '#000000',
        'items' => [
            [
                'id' => 'contact_1',
                'icon' => '/img/Iconos/IDCBIS.svg',
                'text' => 'Carrera 32 #12-81, Bogotá',
                'title' => 'Sede',
            ],
            [
                'id' => 'contact_2',
                'icon' => '/img/Iconos/contacto.svg',
                'text' => '(+57) 1 3649620',
                'link' => 'tel:+5713649620',
                'title' => 'Teléfono',
            ],
            [
                'id' => 'contact_3',
                'icon' => '/img/Iconos/correo.svg',
                'text' => 'contacto@idcbis.org.co',
                'link' => 'mailto:contacto@idcbis.org.co',
                'title' => 'Mail',
            ],
        ],
        'content' => '',
        'fontSize' => '16px',
        'fullBleed' => true,
        'blockLabel' => 'Contacto',
    ],
];
