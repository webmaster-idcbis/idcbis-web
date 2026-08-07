<?php

/**
 * Contenido de /participa tal como está en la base de datos (bloques del editor).
 * Sincronizado con: php artisan page:sync-data-files
 */

return [
    [
        'id' => 'participa_hero',
        'type' => 'hero',
        'color' => '#ffffff',
        'title' => 'Participa',
        'content' => '',
        'subtitle' => 'En el menú Participa, el IDCBIS publica la información sobre los espacios, mecanismos y acciones que permiten la participación ciudadana, con el propósito de fortalecer la vinculación de la ciudadanía, grupos de interés y de valor, en las decisiones y acciones públicas, durante las fases del ciclo de la gestión pública, según los lineamientos del Departamento Administrativo de la Función Pública y la Alcaldía Mayor de Bogotá.',
        'fullBleed' => true,
        'minHeight' => '300px',
        'textAlign' => 'center',
        'blockLabel' => 'Encabezado',
        'borderRadius' => '1px',
        'backgroundColor' => 'linear-gradient(135deg, #0b4f6c 0%, #2c8c99 100%)',
        'backgroundImage' => '',
    ],
    [
        'id' => 'participa_secciones',
        'type' => 'accordion',
        'items' => [
            [
                'id' => 'participa_sec_diagnostico',
                'links' => [
                    [
                        'id' => 'participa_link_causas',
                        'url' => 'https://participacion.gobiernoabiertobogota.gov.co/causas/contexto/',
                        'label' => 'Causas ciudadanas',
                        'description' => 'Propón y apoya causas ciudadanas para el diagnóstico de necesidades e identificación de problemas.',
                    ],
                ],
                'answer' => '',
                'question' => 'Participación para el diagnóstico de necesidades e identificación de problemas',
            ],
            [
                'id' => 'participa_sec_colaboracion',
                'links' => [
                    [
                        'id' => 'participa_link_conoce',
                        'url' => 'https://gobiernoabiertobogota.gov.co/#/transparencia',
                        'label' => 'Conoce',
                        'description' => 'Información clave sobre Bogotá y su gestión: declaraciones de bienes y renta, conflictos de interés, datos abiertos del Distrito y avance del Plan de Desarrollo.',
                    ],
                    [
                        'id' => 'participa_link_propone',
                        'url' => 'https://bogota.gov.co/sdqs/',
                        'label' => 'Propone',
                        'description' => 'Envía propuestas de mejora sobre nuestra gestión. Las discutiremos en las instancias internas de decisión y te daremos respuesta sobre su viabilidad.',
                    ],
                    [
                        'id' => 'participa_link_tutorial',
                        'url' => 'https://bogota.gov.co/sdqs/videos',
                        'label' => 'Tutorial para enviar propuestas (SDQS)',
                        'description' => 'Consulta un tutorial sobre cómo enviar sugerencias y propuestas de mejora.',
                    ],
                    [
                        'id' => 'participa_link_prioriza',
                        'url' => 'https://gobiernoabiertobogota.gov.co/#/participacion',
                        'label' => 'Prioriza',
                        'description' => 'Propón tus causas ciudadanas, vota en los procesos electorales de las instancias locales y decide la inversión de tu localidad con los presupuestos participativos.',
                    ],
                ],
                'answer' => 'Bogotá es un gobierno de puertas abiertas comprometido con la transparencia y la lucha contra la corrupción. En el Distrito nos proponemos promover una senda de la integridad a partir de prácticas de gobierno abierto y de fomento de nuevos valores que transformen la relación entre la administración y la ciudadanía. Por eso, aquí tendrás acceso a estrategias de transparencia, de participación y de colaboración, de tal manera que puedas conocer, proponer y priorizar soluciones a los retos de nuestra ciudad.',
                'question' => 'Colaboración e innovación abierta con la participación ciudadana',
            ],
            [
                'id' => 'participa_sec_rendicion',
                'links' => [
                    [
                        'id' => 'participa_link_rendicion',
                        'url' => 'https://idcbis.org.co/rendicion-de-cuentas/',
                        'label' => 'Rendición de cuentas',
                        'description' => 'Consulta los informes y espacios de rendición de cuentas del IDCBIS ante la ciudadanía.',
                    ],
                ],
                'answer' => '',
                'question' => 'Rendición de cuentas',
            ],
        ],
        'title' => 'Participación ciudadana',
        'subtitle' => 'Despliega cada sección para conocer los espacios y mecanismos disponibles.',
        'blockLabel' => 'Secciones de participación',
        'titleColor' => '#0b4f6c',
        'subtitleColor' => '#475569',
        'backgroundColor' => '#f0f5f8',
    ],
];
