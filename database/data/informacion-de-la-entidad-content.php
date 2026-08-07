<?php

/**
 * Contenido de /informacion-de-la-entidad tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'entidad_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Información de la entidad',
        'content' => '',
        'subtitle' => 'Misión, visión, funciones, organigrama, directorios, políticas y entes de vigilancia del IDCBIS.',
        'fullBleed' => true,
        'minHeight' => '280px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'entidad_secciones',
        'type' => 'accordion',
        'items' => [
            [
                'id' => 'entidad_mision',
                'links' => [
                    [
                        'id' => 'entidad_link_qs',
                        'url' => '/quienes-somos',
                        'label' => 'Quiénes somos',
                        'description' => 'Conozca más sobre la historia, valores y equipo del instituto.',
                    ],
                ],
                'answer' => 'Misión
Somos un instituto de ciencia, tecnología e innovación en salud, con énfasis en investigación médica y biotecnológica, que genera conocimiento y desarrollo científico, sobre la base del fortalecimiento de las capacidades del talento humano, infraestructura, cultura de la calidad y compromiso social, para la gestión de conocimiento y la provisión de productos e insumos biológicos humanos al servicio de la población.

Visión
En el 2030, seremos un instituto de excelencia en ciencia, tecnología e innovación, de referencia nacional e internacional en salud poblacional, con una cultura organizacional, basada en un sistema de gestión del conocimiento y un talento comprometido para el bienestar y desarrollo de la comunidad.',
                'question' => 'Misión y visión',
            ],
            [
                'id' => 'entidad_plan',
                'links' => [
                    [
                        'id' => 'entidad_link_plan',
                        'url' => 'https://idcbis.org.co/documentos/planeacion/PLAN-ESTRATEGICO-2021-A-2025.pdf',
                        'label' => 'Plan estratégico 2021 a 2025',
                        'description' => 'Documento del plan estratégico del IDCBIS.',
                    ],
                ],
                'answer' => 'Consulte el plan estratégico institucional vigente.',
                'question' => 'Plan Estratégico',
            ],
            [
                'id' => 'entidad_funciones',
                'links' => [
                    [
                        'id' => 'entidad_link_acuerdo',
                        'url' => '/normativa',
                        'label' => 'Normativa relacionada',
                        'description' => 'Consulte el normograma y los acuerdos distritales.',
                    ],
                ],
                'answer' => 'Acuerdo 761 de 2020 «Por medio del cual se adopta el Plan de desarrollo económico, social, ambiental y de obras públicas del Distrito Capital 2020-2024 “Un nuevo contrato social y ambiental para la Bogotá del siglo XXI”».

Artículo 102. Funciones esenciales del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud. Modifíquese el artículo 18 del Acuerdo 641 de 2016 el cual quedará así:

«Artículo 18. El Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud –IDCBIS- desarrollará las siguientes actividades principales:

a). Fortalecer y fomentar una cultura ciudadana para la donación de sangre, componentes sanguíneos, órganos y tejidos humanos y células con propósitos de trasplante, medicina regenerativa o investigación.

b). Obtener, procesar, almacenar y distribuir componentes sanguíneos, tejidos y células humanas con propósitos de trasplante, medicina regenerativa o investigación.

c). Ofrecer servicios altamente especializados y de referencia, en banco de sangre, banco de tejidos humanos, banco de sangre de cordón umbilical, terapias avanzadas, medicina transfusional, medicina regenerativa y laboratorio de inmunología de transfusión y trasplantes.

d). Formar, capacitar y entrenar talento humano en las áreas de conocimiento desarrolladas por la entidad, con énfasis en investigación.

e). Gestionar líneas de investigación e innovación tecnológica en diversos campos de las ciencias de la salud humana, con énfasis en medicina transfusional, ingeniería tisular, terapias avanzadas y medicina regenerativa, en coordinación con centros académicos y de investigación nacionales e internacionales.

f). Servir como entidad asesora, consultora y de referencia, para entidades nacionales e internacionales en los aspectos relacionados con el desarrollo de su objeto social.

g). Desarrollar y gestionar un Registro de Donantes de Progenitores Hematopoyéticos, con propósitos de investigación y trasplante.

h). Desarrollar actividades encaminadas a la apropiación social del conocimiento en el área de la salud, así como la difusión de la ciencia.

i). Las demás actividades que señalen los estatutos y que sean conexas con su objeto social.»',
                'question' => 'Funciones y deberes',
            ],
            [
                'id' => 'entidad_organigrama',
                'image' => 'https://idcbis.org.co/wp-content/uploads/2021/08/Organigrama-2021-min-1.png',
                'links' => [],
                'answer' => 'Estructura orgánica del Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud — IDCBIS.',
                'imageAlt' => 'Organigrama del IDCBIS',
                'question' => 'Organigrama',
            ],
            [
                'id' => 'entidad_procesos',
                'links' => [
                    [
                        'id' => 'entidad_link_mapas',
                        'url' => 'https://idcbis.org.co/pdf/Mapa_de_procesos_2023.pdf',
                        'label' => 'Mapas de los procesos',
                        'description' => 'Mapa de procesos institucionales.',
                    ],
                    [
                        'id' => 'entidad_link_cartas',
                        'url' => 'https://idcbis.org.co/pdf/Carta_Descriptiva_de_los_procesos.pdf',
                        'label' => 'Carta Descriptiva de los procesos',
                        'description' => 'Cartas descriptivas de los procesos del IDCBIS.',
                    ],
                ],
                'answer' => '',
                'question' => 'Mapas y cartas descriptivas de los procesos',
            ],
            [
                'id' => 'entidad_dir_institucional',
                'links' => [
                    [
                        'id' => 'entidad_link_dir_inst',
                        'url' => 'https://idcbis.org.co/pdf/Directorio-IDCBIS.pdf',
                        'label' => 'Directorio Institucional',
                        'description' => 'Directorio institucional del IDCBIS.',
                    ],
                    [
                        'id' => 'entidad_link_contacto',
                        'url' => '/contacto',
                        'label' => 'Contáctenos',
                        'description' => 'Formulario y canales de contacto institucionales.',
                    ],
                ],
                'answer' => 'Instituto Distrital de Ciencia, Biotecnología e Innovación en Salud — IDCBIS

Instalaciones: Carrera 32 No. 12-81, Edificio IDCBIS, Secretaría Distrital de Salud, Bogotá – Colombia
Teléfono: PBX (+57) 1 3649620
Email: contacto@idcbis.org.co
Notificaciones judiciales: idcbis@idcbis.org.co
Horario de atención: lunes a viernes, 8:00 a. m. – 5:00 p. m.',
                'question' => 'Directorio Institucional',
            ],
            [
                'id' => 'entidad_dir_empleados',
                'links' => [
                    [
                        'id' => 'entidad_link_dir_emp',
                        'url' => 'https://idcbis.org.co/pdf/Directorio_de_empleados_y_contratistas_2025.pdf',
                        'label' => 'Directorio de empleados y contratistas',
                        'description' => 'Listado de funcionarios y contratistas del instituto.',
                    ],
                ],
                'answer' => 'Consulte el directorio de empleados y contratistas del IDCBIS.',
                'question' => 'Directorio de empleados y contratistas',
            ],
            [
                'id' => 'entidad_dir_entidades',
                'links' => [
                    [
                        'id' => 'entidad_ent_minsalud',
                        'url' => 'https://www.minsalud.gov.co/',
                        'label' => 'Ministerio de Salud y Protección Social',
                        'description' => 'Entidad del sector salud a nivel nacional.',
                    ],
                    [
                        'id' => 'entidad_ent_invima',
                        'url' => 'http://www.invima.gov.co/',
                        'label' => 'Instituto Nacional de Vigilancia de Medicamentos y Alimentos — INVIMA',
                        'description' => 'Vigilancia sanitaria de medicamentos, alimentos y dispositivos médicos.',
                    ],
                    [
                        'id' => 'entidad_ent_sds',
                        'url' => 'http://www.saludcapital.gov.co/',
                        'label' => 'Secretaría Distrital de Salud',
                        'description' => 'Secretaría Distrital de Salud de Bogotá.',
                    ],
                    [
                        'id' => 'entidad_ent_subred_norte',
                        'url' => 'http://www.subrednorte.gov.co/',
                        'label' => 'Subred Integrada de Servicios de Salud Norte',
                        'description' => 'Subred Norte E.S.E.',
                    ],
                    [
                        'id' => 'entidad_ent_subred_sur',
                        'url' => 'https://www.subredsur.gov.co/',
                        'label' => 'Subred Integrada de Servicios de Salud Sur',
                        'description' => 'Subred Sur E.S.E.',
                    ],
                    [
                        'id' => 'entidad_ent_subred_so',
                        'url' => 'https://www.subredsuroccidente.gov.co/',
                        'label' => 'Subred Integrada de Servicios de Salud Sur Occidente',
                        'description' => 'Subred Sur Occidente E.S.E.',
                    ],
                    [
                        'id' => 'entidad_ent_subred_co',
                        'url' => 'https://www.subredcentrooriente.gov.co/',
                        'label' => 'Subred Integrada de Servicios de Salud Centro Oriente',
                        'description' => 'Subred Centro Oriente E.S.E.',
                    ],
                ],
                'answer' => 'Entidades del sector salud y relacionadas con el IDCBIS.',
                'question' => 'Directorio de entidades',
            ],
            [
                'id' => 'entidad_dir_agremiaciones',
                'links' => [
                    [
                        'id' => 'entidad_agr_uptc',
                        'url' => 'https://www.uptc.edu.co/sitio/portal/',
                        'label' => 'Universidad Pedagógica y Tecnológica de Colombia',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_uan',
                        'url' => 'https://www.uan.edu.co/',
                        'label' => 'Universidad Antonio Nariño',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_rosario',
                        'url' => 'https://www.urosario.edu.co/',
                        'label' => 'Universidad del Rosario',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_sabana',
                        'url' => 'https://www.unisabana.edu.co/',
                        'label' => 'Universidad de La Sabana',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_unal',
                        'url' => 'https://unal.edu.co/',
                        'label' => 'Universidad Nacional de Colombia',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_fidic',
                        'url' => 'http://www.fidic.org.co/pagina/index.html',
                        'label' => 'Fundación Instituto de Inmunología de Colombia — FIDIC',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_unicolmayor',
                        'url' => 'https://www.universidadmayor.edu.co/',
                        'label' => 'Universidad Colegio Mayor de Cundinamarca',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_andes',
                        'url' => 'https://uniandes.edu.co/',
                        'label' => 'Universidad de Los Andes',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_javeriana',
                        'url' => 'https://www.javeriana.edu.co/inicio',
                        'label' => 'Pontificia Universidad Javeriana',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_uis',
                        'url' => 'https://uis.edu.co/inicio/',
                        'label' => 'Universidad Industrial de Santander',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_fucs',
                        'url' => 'https://www.fucsalud.edu.co/',
                        'label' => 'Fundación Universitaria de Ciencias de la Salud',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_ocyt',
                        'url' => 'https://ocyt.org.co/',
                        'label' => 'OCyT — Observatorio Colombiano de Ciencia y Tecnología',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_acdt',
                        'url' => 'https://www.acodet.com.co/',
                        'label' => 'Asociación Colombiana de Deportistas Trasplantados',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_ins',
                        'url' => 'https://www.ins.gov.co/Paginas/Inicio.aspx',
                        'label' => 'Instituto Nacional de Salud',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_pediatrica',
                        'url' => 'http://fundacionhomi.org.co/',
                        'label' => 'Fundación Hospital Pediátrico',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_udea',
                        'url' => 'https://www.udea.edu.co/',
                        'label' => 'Universidad de Antioquia',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_dpz',
                        'url' => 'https://www.dpz.eu/de/startseite.html',
                        'label' => 'Das Deutsche Primatenzentrum (DPZ)',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_inc',
                        'url' => 'https://www.cancer.gov.co/',
                        'label' => 'Instituto Nacional de Cancerología',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_dri',
                        'url' => 'https://umiamihealth.org/en/locations/uhealth-diabetes-research-institute',
                        'label' => 'Diabetes Research Institute — University of Miami',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_bst',
                        'url' => 'https://www.bancsang.net/es_index/',
                        'label' => 'Banc de Sang i Teixits',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_fecoer',
                        'url' => 'http://www.fecoer.org/',
                        'label' => 'Federación Colombiana de Enfermedades Raras',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_agr_procure',
                        'url' => 'http://www.procurediabetes.org/',
                        'label' => 'The Pro Cure Diabetes Healing Foundation',
                        'description' => '',
                    ],
                ],
                'answer' => 'Universidades, centros de investigación y organizaciones aliadas del IDCBIS.',
                'question' => 'Directorio de agremiaciones, asociaciones y otros grupos de interés',
            ],
            [
                'id' => 'entidad_servicio_publico',
                'links' => [
                    [
                        'id' => 'entidad_link_atencion',
                        'url' => 'https://idcbis.org.co/atencion-a-usuarios/',
                        'label' => 'Atención y servicio al ciudadano',
                        'description' => 'Canales, horarios y procedimientos de atención.',
                    ],
                ],
                'answer' => '',
                'question' => 'Servicio al público, normas, formularios y protocolos de atención',
            ],
            [
                'id' => 'entidad_politicas',
                'links' => [
                    [
                        'id' => 'entidad_pol_calidad',
                        'url' => 'https://idcbis.org.co/documentos/entidad/POLITICA_DE_GESTIÓN_DE_CALIDAD_v1.pdf',
                        'label' => 'Política de Gestión de Calidad',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_pol_riesgos',
                        'url' => 'https://idcbis.org.co/documentos/entidad/Politica_administracion_de_riesgos.pdf',
                        'label' => 'Política de Administración de riesgos',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_pol_conocimiento',
                        'url' => 'https://idcbis.org.co/documentos/entidad/Politica_de_Gestion_del_Conocimiento_2023.pdf',
                        'label' => 'Política de Gestión del Conocimiento',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_pol_documental',
                        'url' => 'https://idcbis.org.co/documentos/entidad/Politica_de_Gestion_Documental.pdf',
                        'label' => 'Política de Gestión Documental',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_pol_interes',
                        'url' => 'https://idcbis.org.co/documentos/entidad/Política_de_relacionamiento_con_grupos_de_interes.pdf',
                        'label' => 'Política de Relacionamiento con Grupos de Interés',
                        'description' => '',
                    ],
                    [
                        'id' => 'entidad_pol_seguridad',
                        'url' => 'https://idcbis.org.co/documentos/TI/politica_seguridad_de_la_informacion.pdf',
                        'label' => 'Política de Seguridad y Privacidad de la Información',
                        'description' => '',
                    ],
                ],
                'answer' => 'Políticas institucionales que orientan la gestión y la toma de decisiones en las diferentes áreas.',
                'question' => 'Procedimientos que se siguen para tomar decisiones en las diferentes áreas',
            ],
            [
                'id' => 'entidad_pqrs',
                'links' => [
                    [
                        'id' => 'entidad_link_pqrs',
                        'url' => 'https://idcbis.org.co/atencion-a-usuarios/',
                        'label' => 'Mecanismo de presentación directa de solicitudes, quejas y reclamos',
                        'description' => 'Canales de atención y radicación de peticiones.',
                    ],
                ],
                'answer' => '',
                'question' => 'Mecanismo de presentación directa de solicitudes, quejas y reclamos',
            ],
            [
                'id' => 'entidad_calendario',
                'links' => [
                    [
                        'id' => 'entidad_link_calendario',
                        'url' => 'https://calendar.google.com/calendar/embed?src=c_2f9e3b46d83eec9fb1c5a905b404ecede2138ce68fadcf5c337892fc4733f95f%40group.calendar.google.com&ctz=America%2FBogota',
                        'label' => 'Abrir calendario de actividades',
                        'description' => 'Calendario institucional embebido desde Google Calendar.',
                    ],
                ],
                'answer' => 'Consulte el calendario de actividades institucionales del IDCBIS.',
                'question' => 'Calendario de actividades',
            ],
            [
                'id' => 'entidad_vigilancia',
                'links' => [
                    [
                        'id' => 'entidad_link_personeria',
                        'url' => 'http://www.personeriabogota.gov.co/',
                        'label' => 'Personería de Bogotá',
                        'description' => 'Control disciplinario.',
                    ],
                    [
                        'id' => 'entidad_link_contraloria',
                        'url' => 'http://www.contraloriabogota.gov.co/',
                        'label' => 'Contraloría Distrital de Bogotá',
                        'description' => 'Control fiscal.',
                    ],
                    [
                        'id' => 'entidad_link_veeduria',
                        'url' => 'http://www.veeduriadistrital.gov.co/',
                        'label' => 'Veeduría Distrital',
                        'description' => 'Control preventivo.',
                    ],
                    [
                        'id' => 'entidad_link_invima2',
                        'url' => 'http://www.invima.gov.co/',
                        'label' => 'INVIMA',
                        'description' => 'Control técnico-científico.',
                    ],
                    [
                        'id' => 'entidad_link_sjd',
                        'url' => 'https://www.secretariajuridica.gov.co',
                        'label' => 'Secretaría Jurídica Distrital',
                        'description' => 'Inspección, vigilancia y control sobre ESAL.',
                    ],
                    [
                        'id' => 'entidad_link_procuraduria',
                        'url' => 'http://www.procuraduria.gov.co/',
                        'label' => 'Procuraduría General de la Nación',
                        'description' => 'Control disciplinario.',
                    ],
                    [
                        'id' => 'entidad_link_cgr',
                        'url' => 'http://www.contraloria.gov.co/',
                        'label' => 'Contraloría General de la República',
                        'description' => 'Control fiscal.',
                    ],
                ],
                'answer' => 'Según el artículo 5 del Decreto 1421 de 1993 «Por el cual se dicta el régimen especial para el Distrito Capital de Santafé de Bogotá»: Son organismos de control y vigilancia la Personería, la Contraloría y la Veeduría. Además, al IDCBIS lo vigila el INVIMA por su actividad misional y la Alcaldía Mayor de Bogotá, al ser una Entidad Sin Ánimo de Lucro.

Mecanismos internos de supervisión, notificación y vigilancia pertinente del sujeto obligado:

El Área de Auditoría Interna es la encargada del Sistema de Control Interno en el marco del Modelo Estándar de Control Interno (Dimensión 7 MIPG), aplicable al IDCBIS. Sus roles estratégico, de enfoque hacia la prevención y de evaluación y seguimiento, se llevan a cabo a través de la realización de auditorías internas con enfoque de riesgo, fomento de la cultura del control y en general un acompañamiento y examen objeto de los sistemas de gestión del Instituto, sus procesos y actividades para formular recomendaciones en el marco del mejoramiento continuo del IDCBIS.',
                'question' => 'Entes y autoridades de vigilancia',
            ],
            [
                'id' => 'entidad_estatutos',
                'links' => [
                    [
                        'id' => 'entidad_link_estatutos',
                        'url' => 'https://idcbis.org.co/documentos/presupuesto/Estatutos_IDCBIS.pdf',
                        'label' => 'Estatutos IDCBIS',
                        'description' => 'Estatutos de la entidad.',
                    ],
                ],
                'answer' => 'Consulte los estatutos de la entidad.',
                'question' => 'Estatutos IDCBIS',
            ],
            [
                'id' => 'entidad_marca',
                'links' => [
                    [
                        'id' => 'entidad_link_marca',
                        'url' => 'https://idcbis.org.co/documentos/entidad/manual_de_marca_IDCBIS.pdf',
                        'label' => 'Manual de marca IDCBIS',
                        'description' => 'Lineamientos de identidad visual institucional.',
                    ],
                ],
                'answer' => '',
                'question' => 'Manual de marca IDCBIS',
            ],
        ],
        'title' => 'Información de la entidad',
        'subtitle' => 'Despliegue cada sección para consultar la información publicada, según los lineamientos de transparencia.',
        'fullBleed' => true,
        'blockLabel' => 'Secciones',
        'titleColor' => '#0b4f6c',
        'subtitleColor' => '#475569',
        'backgroundColor' => '#f0f5f8',
    ],
];
