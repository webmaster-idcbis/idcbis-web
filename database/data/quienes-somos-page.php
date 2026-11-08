<?php

/**
 * Datos del bloque idcbis-quienes-somos (página completa).
 * Fuente: https://idcbis.org.co/quienes-somos/
 */

$member = static function (
    string $id,
    string $name,
    string $role,
    string $email,
    string $credentials,
    string $photoSlug,
): array {
    return compact('id', 'name', 'role', 'email', 'credentials', 'photoSlug');
};

return [
    'id' => 'qs_page',
    'type' => 'idcbis-quienes-somos',
    'content' => '',
    'fullBleed' => true,
    'heroTitle' => 'Quiénes Somos',
    'heroSubtitle' => 'Ciencia, biotecnología e innovación en salud para Bogotá y Colombia',
    'heroEyebrow' => 'Instituto IDCBIS',
    'heroImage' => '/img/Quienes-Somos-l-IDCBIS-2020.png',
    'intro' => [
        'El Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud (IDCBIS) es una corporación de carácter mixto, en pro de la salud individual y colectiva, sin ánimo de lucro, con personería jurídica de derecho privado, autonomía administrativa, financiera y patrimonio propio, vinculada a la Secretaría Distrital de Salud.',
        'El IDCBIS surge de la iniciativa de fortalecer la labor de más de 15 años de un equipo que, con el apoyo de la administración distrital, el Honorable Concejo de Bogotá y bajo los lineamientos de su dirección científica, convirtió al Banco de Sangre, Tejidos y Células — Hemocentro Distrital — en un referente técnico-científico en la ciudad, el país y la región.',
    ],
    'mission' => 'Somos un instituto de ciencia, tecnología e innovación en salud, con énfasis en investigación médica y biotecnológica, que genera conocimiento y desarrollo científico sobre la base del fortalecimiento de las capacidades del talento humano, infraestructura, cultura de la calidad y compromiso social, para la gestión de conocimiento y la provisión de productos e insumos biológicos humanos al servicio de la población.',
    'vision' => 'En el 2030, seremos un instituto de excelencia en ciencia, tecnología e innovación, de referencia nacional e internacional en salud poblacional, con una cultura organizacional basada en un sistema de gestión del conocimiento y un talento comprometido para el bienestar y desarrollo de la comunidad.',
    'purpose' => 'Generamos valor público, impactando la salud poblacional con ciencia, tecnología e innovación.',
    'principles' => [
        [
            'id' => 'pr1',
            'icon' => '⭐',
            'title' => 'Excelencia técnica y científica',
            'image' => '/img/principios/excelencia.jpg',
            'imageAlt' => 'Profesional científica sonriente con bata y estetoscopio',
        ],
        [
            'id' => 'pr2',
            'icon' => '⚖️',
            'title' => 'Ética pública e integridad científica',
            'image' => '/img/principios/etica.jpg',
            'imageAlt' => 'Profesionales de la salud sonriendo en un entorno clínico',
        ],
        [
            'id' => 'pr3',
            'icon' => '❤️',
            'title' => 'Propósito social',
            'image' => '/img/principios/proposito-social.jpg',
            'imageAlt' => 'Grupo de voluntarios diversos sonriendo frente a una camioneta',
        ],
        [
            'id' => 'pr4',
            'icon' => '🔍',
            'title' => 'Transparencia',
            'image' => '/img/principios/transparencia.jpg',
            'imageAlt' => 'Equipo diverso en reunión abierta sellando un acuerdo con una sonrisa',
        ],
        [
            'id' => 'pr5',
            'icon' => '⚙️',
            'title' => 'Gestión eficiente',
            'image' => '/img/principios/gestion.jpg',
            'imageAlt' => 'Equipo analizando datos y gráficos en una mesa de trabajo colaborativa',
        ],
    ],
    'director' => [
        'name' => 'Gustavo Salguero López',
        'role' => 'Director – Representante legal del IDCBIS',
        'credentials' => 'MD. PhD. MBA',
        'email' => 'DireccionIDCBIS@idcbis.org.co',
        'photoSlug' => 'gustavo-andres-salguero',
        'bio' => 'Médico de la Universidad Nacional de Colombia. Doctor en la Escuela de Medicina de Hannover (Alemania), con experiencia en cardiología molecular e inmunoterapias regenerativas. Desde 2015 dirigió la Unidad de Terapia Celular del Hemocentro de la Secretaría Distrital de Salud y desde 2017 lidera investigación en terapias avanzadas del IDCBIS. Cuenta con más de 15 años de experiencia postdoctoral en investigación y desarrollo de tecnologías de terapia avanzada.',
    ],
    'sections' => [
        [
            'id' => 'funciones',
            'title' => 'Funciones del IDCBIS',
            'icon' => '/img/Iconos/Funciones IDCBIS.svg',
            'layout' => 'list',
            'items' => [
                'Fortalecer y fomentar una cultura ciudadana para la donación de sangre, componentes sanguíneos, órganos y tejidos humanos y células con propósitos de trasplante, medicina regenerativa o investigación.',
                'Obtener, procesar, almacenar y distribuir componentes sanguíneos, tejidos y células humanas con propósitos de trasplante, medicina regenerativa o investigación.',
                'Servir como entidad asesora, consultora y de referencia para entidades nacionales e internacionales en los aspectos relacionados con el desarrollo de su objeto social.',
                'Gestionar líneas de investigación e innovación tecnológica en ciencias de la salud humana, con énfasis en medicina transfusional, ingeniería tisular, terapias avanzadas y medicina regenerativa.',
                'Ofrecer servicios altamente especializados en banco de sangre, banco de tejidos, banco de cordón umbilical, terapias avanzadas y laboratorio de inmunología de transfusión y trasplantes.',
                'Desarrollar y gestionar un Registro de Donantes de Progenitores Hematopoyéticos con propósitos de investigación y trasplante.',
                'Desarrollar actividades de apropiación social del conocimiento en el área de la salud y difusión de la ciencia.',
                'Las demás actividades que señalen los estatutos y que sean conexas con su objeto social.',
            ],
        ],
        [
            'id' => 'organigrama',
            'title' => 'Organigrama',
            'icon' => '/img/Iconos/organigrama.svg',
            'layout' => 'organigrama',
            'description' => 'Estructura orgánica del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud — IDCBIS.',
            'image' => '/img/Organigrama-2021.png',
            'imageAlt' => 'Organigrama del IDCBIS: Asamblea, Junta Directiva, Dirección General y grupos de investigación, servicios y gestión',
            'caption' => 'Haz clic en la imagen para ampliarla',
        ],
        [
            'id' => 'fundadores',
            'title' => 'Miembros fundadores',
            'icon' => '🏛️',
            'layout' => 'founders',
            'items' => [
                [
                    'name' => 'Secretaría Distrital de Salud',
                    'logo' => 'https://www.saludcapital.gov.co/SiteAssets/customdesign/images/LOGO-WEB-Bogota.png',
                    'url' => 'https://www.saludcapital.gov.co/',
                ],
                [
                    'name' => 'Subred Integrada de Servicios de Salud Norte E.S.E.',
                    'logo' => 'https://www.subrednorte.gov.co/wp-content/uploads/2023/09/logo-subred-blanco.png',
                    'url' => 'https://www.subrednorte.gov.co/',
                    'logoOnDark' => true,
                ],
                [
                    'name' => 'Subred Integrada de Servicios de Salud Sur Occidente E.S.E.',
                    'logo' => 'https://subredsuroccidente.gov.co/wp-content/themes/sekure/assets/images/logo/logo.png',
                    'url' => 'https://subredsuroccidente.gov.co/',
                ],
                [
                    'name' => 'Subred Integrada de Servicios de Salud Sur E.S.E.',
                    'logo' => 'https://www.subredsur.gov.co/wp-content/uploads/2026/08/Logo_Bogota_SDS-scaled.png',
                    'url' => 'https://www.subredsur.gov.co/',
                ],
                [
                    'name' => 'Subred Integrada de Servicios de Salud Centro Oriente E.S.E.',
                    'logo' => 'https://subredcentrooriente.gov.co/sites/default/files/header-institucional/EncabezadoPag_1.png',
                    'url' => 'https://subredcentrooriente.gov.co/',
                ],
                [
                    'name' => 'Universidad Nacional de Colombia',
                    'logo' => 'https://unal.edu.co/typo3conf/ext/unal_skin_default/Resources/Public/images/escudoUnal_black.png',
                    'url' => 'https://unal.edu.co/',
                ],
                [
                    'name' => 'Universidad de los Andes',
                    'logo' => 'https://www.uniandes.edu.co/sites/default/files/FAVICON-Uniandes-of.png',
                    'url' => 'https://uniandes.edu.co/',
                ],
                [
                    'name' => 'Pontificia Universidad Javeriana',
                    'logo' => 'https://www.javeriana.edu.co/inicio/files/escudoPUJ-Bogota_rgb-azul_lateral.png',
                    'url' => 'https://www.javeriana.edu.co/',
                ],
                [
                    'name' => 'Universidad del Rosario',
                    'logo' => 'https://urosario.edu.co/themes/custom/urosario/images/logo.svg',
                    'url' => 'https://www.urosario.edu.co/',
                ],
                [
                    'name' => 'Instituto Nacional de Cancerología — E.S.E.',
                    'logo' => 'https://www.cancer.gov.co/_templates/CANCER-PORTAL-2022/recursos/images/cabezote/Logo-INC.svg',
                    'url' => 'https://www.cancer.gov.co/',
                ],
            ],
        ],
        [
            'id' => 'equipo',
            'title' => 'Grupo de líderes y responsables',
            'icon' => '👥',
            'layout' => 'team',
            'members' => [
                $member('m01', 'Bernardo Armando Camacho Rodríguez', 'Gestor y director — investigador IDCBIS', 'bacamacho@idcbis.org.co', 'Médico cirujano. MSc. Mg. CTI.', 'bernardo-armando-camacho-rodriguez'),
                $member('m02', 'Gustavo Andrés Salguero', 'Director – representante legal del IDCBIS', 'DireccionIDCBIS@idcbis.org.co', 'MD. Ph.D. MBA', 'gustavo-andres-salguero'),
                $member('m03', 'Ingrid Zulay Silva Cote', 'Líder científica de ingeniería tisular — Unidad de terapias avanzadas', 'izsilva@idcbis.org.co', 'Bacterióloga. MSc. Ph.D.', 'ingrid-zulay-silva-cote'),
                $member('m04', 'Alvaro Ignacio Guerrero Devia', 'Líder financiero', 'aiguerrero@idcbis.org.co', 'Contador público. Esp.', 'alvaro-ignacio-guerrero-devia'),
                $member('m05', 'Diana Carolina Camelo Sánchez', 'Líder administrativa y de proyectos estratégicos', 'dcamelo@idcbis.org.co', 'Administradora en salud. Esp. MSc.', 'diana-carolina-camelo-sanchez'),
                $member('m06', 'Ana María Perdomo', 'Líder científica del Banco Público de Sangre de Cordón Umbilical', 'amperdomo@idcbis.org.co', 'Médica cirujana. MSc. Ph.D.', 'ana-maria-perdomo'),
                $member('m07', 'Jenny Johana Pinilla Gómez', 'Líder de inmunohematología', 'jpinilla@idcbis.org.co', 'Bacterióloga y laboratorista clínica. Esp.', 'jenny-johana-pinilla-gomez'),
                $member('m08', 'César Augusto Ramírez Segura', 'Líder del laboratorio de ingeniería molecular y celular', 'cramirez@idcbis.org.co', 'Biólogo. Ph.D.', 'cesar-augusto-ramirez-segura'),
                $member('m09', 'Carlos Ayala Grosso', 'Líder científico de investigación en neurociencias', 'c1ayala@idcbis.org.co', 'Biólogo. MSc. Ph.D.', 'carlos-ayala-grosso'),
                $member('m10', 'Sonia Patricia Forero', 'Directora técnica del Banco Distrital de Sangre', 'spforero@idcbis.org.co', 'Bacterióloga. Esp. MSc.', 'sonia-patricia-forero'),
                $member('m11', 'Jhon Alexander Bello Sepúlveda', 'Director técnico del Banco Distrital de Tejidos', 'jbello@idcbis.org.co', 'Microbiólogo y bioanalista. Bioingeniería y nanotecnología', 'jhon-alexander-bello-sepulveda'),
                $member('m12', 'Paula Andrea Gaviria', 'Líder de inmunohematología avanzada', 'pgaviria@idcbis.org.co', 'Bacterióloga. MSc.', 'paula-andrea-gaviria'),
                $member('m13', 'Paola Andrea Cendales Rodríguez', 'Líder técnica del programa DarCélulas', 'pacendales@idcbis.org.co', 'Enfermera. MSc.', 'paola-andrea-cendales-rodriguez'),
                $member('m14', 'Leidi Yohana Méndez Báez', 'Líder del área de microbiología', 'microbiologia@idcbis.org.co', 'Bacterióloga y laboratorista clínica. Esp. MSc.', 'leidi-yohana-mendez-baez'),
                $member('m15', 'Marcela Eugenia Gutiérrez Esquivel', 'Líder de comunicaciones', 'mgutierrez@idcbis.org.co', 'Comunicadora social. Esp. Mg.', 'marcela-eugenia-gutierrez-esquivel'),
                $member('m16', 'Sindy Lorena Álvarez Hernández', 'Líder de gestión del conocimiento', 'salvarez@idcbis.org.co', 'Enfermera. MSc.', 'sindy-lorena-alvarez-hernandez'),
                $member('m17', 'William Idarraga Ariza', 'Líder de planeación financiera', 'planeacionfinanciera@idcbis.org.co', 'Ingeniero de sistemas. Esp. en administración financiera', 'william-idarraga-ariza'),
                $member('m18', 'Jeimi Martínez Osorio', 'Líder de planeación institucional', 'jmosorio@idcbis.org.co', 'Ingeniera industrial. Esp.', 'jeimi-martinez-osorio'),
                $member('m19', 'Mariana Cañas', 'Líder de innovación biofarmacéutica y biodispositivos', 'mcanas@idcbis.org.co', 'Biotecnóloga. Mg.', 'mariana-canas'),
                $member('m20', 'Gina Alexandra Mendoza Rodríguez', 'Responsable de gestión del talento humano', 'contacto@idcbis.org.co', 'Psicóloga. Esp. en gerencia de recursos humanos', 'gina-alexandra-mendoza-rodriguez'),
                $member('m21', 'Sandra Patricia Gómez Rubio', 'Responsable de bioingeniería e infraestructura', 'spgomez@idcbis.org.co', 'Ingeniera biomédica. Esp.', 'sandra-patricia-gomez-rubio'),
                $member('m22', 'Jaime Jhonatan Rivera Díaz', 'Responsable de gestión ambiental', 'gestionambiental@idcbis.org.co', 'Ingeniero ambiental. Esp.', 'jaime-jhonatan-rivera-diaz'),
                $member('m23', 'José Luis Preciado Gómez', 'Responsable de logística y transporte', 'contacto@idcbis.org.co', 'Administrador de empresas', 'jose-luis-preciado-gomez'),
                $member('m24', 'German Camilo Ramírez Montenegro', 'Responsable de TIC', 'gramirez@idcbis.org.co', 'Ingeniero de sistemas', 'german-camilo-ramirez-montenegro'),
                $member('m25', 'Mary Alejandra Guarnizo Devia', 'Responsable de compras y contratación', 'maguarnizo@idcbis.org.co', 'Abogada. Esp.', 'mary-alejandra-guarnizo-devia'),
            ],
        ],
        [
            'id' => 'politicas',
            'title' => 'Políticas y lineamientos',
            'icon' => '📑',
            'layout' => 'policies',
            'items' => [
                ['title' => 'Política del Sistema Integrado de Gestión', 'description' => 'Lineamientos de calidad y gestión institucional.', 'icon' => '📋', 'url' => 'https://idcbis.org.co/documentos/entidad/'],
                ['title' => 'Política de Administración de Riesgo', 'description' => 'Gestión integral de riesgos institucionales.', 'icon' => '⚠️', 'url' => 'https://idcbis.org.co/documentos/entidad/'],
                ['title' => 'Política de Gestión del Conocimiento', 'description' => 'Apropiación y difusión del conocimiento científico.', 'icon' => '📚', 'url' => 'https://idcbis.org.co/documentos/entidad/Politica_de_Gestion_del_Conocimiento_2023.pdf'],
            ],
        ],
        [
            'id' => 'horarios',
            'title' => 'Horarios y contacto',
            'icon' => '📍',
            'layout' => 'contact',
            'items' => [
                ['icon' => '🏢', 'title' => 'IDCBIS', 'text' => "Lunes a viernes: 8:00 a.m. – 5:00 p.m.\nCarrera 32 No. 12-81, Edificio Hemocentro\nSecretaría Distrital de Salud, Bogotá"],
                ['icon' => '🩸', 'title' => 'Banco Distrital de Sangre', 'text' => "Colecta intramural\nLunes a viernes: 8:00 a.m. – 4:30 p.m.\nSábados y domingos: 7:00 a.m. – 12:00 p.m.\n\nColecta extramural según programación establecida"],
                ['icon' => '📞', 'title' => 'Contacto', 'text' => "PBX (+57) 1 3649620\ncontacto@idcbis.org.co\nNotificaciones judiciales: idcbis@idcbis.org.co"],
            ],
        ],
    ],
];
